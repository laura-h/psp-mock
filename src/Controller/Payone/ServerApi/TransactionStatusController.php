<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace TechDivision\PspMock\Controller\Payone\ServerApi;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use TechDivision\PspMock\Entity\Payone\Order;
use TechDivision\PspMock\Repository\OrderRepository;
use TechDivision\PspMock\Service\EntitySaver;
use TechDivision\PspMock\Service\Payone\ServerApi\CallbackExecutor;

/**
 * @category   TechDivision
 * @package    PspMock
 * @subpackage Controller
 * @copyright  Copyright (c) 2018 TechDivision GmbH (http://www.techdivision.com)
 * @link       http://www.techdivision.com/
 * @author     Vadim Justus <v.justus@techdivision.com
 */
class TransactionStatusController extends AbstractController
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EntitySaver
     */
    private $entitySaver;

    /**
     * @var CallbackExecutor
     */
    private $callbackExecutor;

    /**
     * @param LoggerInterface $logger
     * @param OrderRepository $orderRepository
     * @param EntitySaver $entitySaver
     * @param CallbackExecutor $callbackExecutor
     */
    public function __construct(
        LoggerInterface $logger,
        OrderRepository $orderRepository,
        EntitySaver $entitySaver,
        CallbackExecutor $callbackExecutor
    ) {
        $this->orderRepository = $orderRepository;
        $this->logger = $logger;
        $this->entitySaver = $entitySaver;
        $this->callbackExecutor = $callbackExecutor;
    }

    /**
     * @param int $order
     * @param string $action
     * @return RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute($order, $action)
    {
        try {
            /** @var Order $order */
            $order = $this->getOrderById((int)$order);

            $this->callbackExecutor->execute($order, $action);

            $this->entitySaver->save($order);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
            $this->logger->debug($exception->getTraceAsString());
        }

        return $this->redirectToRoute('gui-order-list', ['type' => 'payone']);
    }

    /**
     * @param int $orderId
     * @return Order
     * @throws \Exception
     */
    private function getOrderById(int $orderId): Order
    {
        /** @var Order $order */
        $order = $this->orderRepository->findOneBy(['id' => $orderId]);
        if (!$order) {
            throw new \Exception(sprintf('Could not find order with given ID: %s', $orderId));
        }
        return $order;
    }

    /**
     * @param Order $order
     * @param string $action
     * @return string
     * @throws \Exception
     */
    private function getNextStatus(Order $order, string $action): string
    {
        $actions = $order->getStatusManager()->getActions();
        foreach ($actions as $actionData) {
            if ($actionData['action'] == $action) {
                return $actionData['status'];
            }
        }

        throw new \Exception('Can not retrieve next status for given order and action!');
    }
}
