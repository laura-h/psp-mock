<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace TechDivision\PspMock\Controller\Heidelpay\ClientApi;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TechDivision\PspMock\Controller\Interfaces\PspAbstractController;
use TechDivision\PspMock\Controller\Interfaces\PspRequestControllerInterface;
use TechDivision\PspMock\Entity\Account;
use TechDivision\PspMock\Entity\Heidelpay\Order;
use TechDivision\PspMock\Repository\Heidelpay\OrderRepository;
use TechDivision\PspMock\Service\ConfigProvider;
use TechDivision\PspMock\Service\EntitySaver;
use TechDivision\PspMock\Service\Heidelpay\ClientApi\ArrayFormatter;
use TechDivision\PspMock\Service\Heidelpay\ClientApi\RequestAccountMapper;
use TechDivision\PspMock\Service\Heidelpay\ClientApi\AckProvider;
use TechDivision\PspMock\Service\Heidelpay\ClientApi\MissingDataProvider;
use TechDivision\PspMock\Service\Heidelpay\ClientApi\NokProvider;
use TechDivision\PspMock\Service\Heidelpay\ClientApi\OrderToResponseDataMapper;
use TechDivision\PspMock\Service\Heidelpay\ClientApi\ConfirmQuoteCaller;
use TechDivision\PspMock\Service\Heidelpay\ClientApi\RedirectCaller;

/**
 * @copyright  Copyright (c) 2019 TechDivision GmbH (https://www.techdivision.com)
 * @link       https://www.techdivision.com/
 * @author     Lukas Kiederle <l.kiederle@techdivision.com
 */
class FrameRequestController extends PspAbstractController implements PspRequestControllerInterface
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @var EntitySaver
     */
    private $entitySaver;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var RequestAccountMapper
     */
    private $accountRequestMapper;

    /**
     * @var OrderToResponseDataMapper
     */
    private $orderToResponseMapper;

    /**
     * @var MissingDataProvider
     */
    private $missingDataProvider;

    /**
     * @var ConfirmQuoteCaller
     */
    private $quoteConfirmer;

    /**
     * @var RedirectCaller
     */
    private $redirectCaller;

    /**
     * @var AckProvider
     */
    private $ackProvider;

    /**
     * @var NokProvider
     */
    private $nokProvider;

    /**
     * @var ArrayFormatter
     */
    private $arrayFormatter;

    /**
     * @var string
     */
    private $failOnIframe;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @param LoggerInterface $logger
     * @param EntitySaver $entitySaver
     * @param OrderRepository $orderRepository
     * @param OrderToResponseDataMapper $orderToResponseMapper
     * @param MissingDataProvider $missingDataProvider
     * @param ConfirmQuoteCaller $quoteConfirmer
     * @param RedirectCaller $redirectCaller
     * @param ConfigProvider $configProvider
     * @param RequestAccountMapper $accountRequestMapper
     * @param AckProvider $ackProvider
     * @param NokProvider $nokProvider
     * @param ArrayFormatter $arrayFormatter
     */
    public function __construct(
        LoggerInterface $logger,
        EntitySaver $entitySaver,
        OrderRepository $orderRepository,
        OrderToResponseDataMapper $orderToResponseMapper,
        MissingDataProvider $missingDataProvider,
        ConfirmQuoteCaller $quoteConfirmer,
        RedirectCaller $redirectCaller,
        ConfigProvider $configProvider,
        RequestAccountMapper $accountRequestMapper,
        AckProvider $ackProvider,
        NokProvider $nokProvider,
        ArrayFormatter $arrayFormatter
    ) {
        parent::__construct($logger);
        $this->entitySaver = $entitySaver;
        $this->orderRepository = $orderRepository;
        $this->orderToResponseMapper = $orderToResponseMapper;
        $this->missingDataProvider = $missingDataProvider;
        $this->quoteConfirmer = $quoteConfirmer;
        $this->redirectCaller = $redirectCaller;
        $this->configProvider = $configProvider;
        $this->accountRequestMapper = $accountRequestMapper;
        $this->ackProvider = $ackProvider;
        $this->nokProvider = $nokProvider;
        $this->arrayFormatter = $arrayFormatter;

        $this->options['asObjects'] = false;

        $this->response = new Response();
        $this->response->headers->set('Content-Type', 'application/json;charset=UTF-8');
        $this->response->headers->set('Transfer-Encoding', 'chunked');
        $this->response->headers->set('Connection', 'close');
        $this->response->headers->set('Keep-Alive', 'timeout=2, max=1000');
        $this->response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $this->response->headers->set('X-Content-Type-Options', 'nosniff');
        $this->response->headers->set('X-XSS-Protection', '1');
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute(Request $request)
    {
        try {
            $this->loadSettings();
            if ($request->getMethod() === "POST") {
                $account = new Account();

                $this->accountRequestMapper->map($request, $account);

                /** @var Order $order */
                $order = $this->orderRepository->findOneBy(
                    array('stateId' => json_decode($request->getContent(), true)['stateId']));

                $order->setAccount($account);

                $this->missingDataProvider->get($order);

                // If flag is set return a 'NOK' Message
                ($this->failOnIframe === '0') ? $this->setAck($order) : $this->nokProvider->get($order);

                $this->entitySaver->save([$order, $account]);

                return $this->buildResponse($order);
            } else {
                throw new \Exception('No such Method supported: ' . $request->getMethod());
            }
        } catch (\Exception $exception) {
            $this->logger->error($exception);
            return new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Order $order
     * @return Response
     * @throws \Exception
     */
    private function buildResponse(Order $order)
    {
        $orderDataArray = $this->orderToResponseMapper->map($order, true);
        $this->response->setContent($this->arrayFormatter->format('json', $orderDataArray));
        return $this->response;
    }

    /**
     * @param Order $order
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function setAck(Order $order)
    {
        $this->ackProvider->get($order);
        // Calls 2 API endpoints of the heidelpay module
        $options = [];
        $this->quoteConfirmer->execute($order, $options);
        $this->redirectCaller->execute($order, $options);
    }

    /**
     * Loads the system settings for Heidelpay requests
     */
    private function loadSettings()
    {
        $this->failOnIframe = $this->configProvider->get($this->options)['heidelpay/fail_on_iframe'];
    }
}
