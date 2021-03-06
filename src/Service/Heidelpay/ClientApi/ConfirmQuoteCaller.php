<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace TechDivision\PspMock\Service\Heidelpay\ClientApi;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use TechDivision\PspMock\Entity\Heidelpay\Order;
use TechDivision\PspMock\Entity\Interfaces\PspOrderInterface;
use TechDivision\PspMock\Service\Interfaces\PspCallerInterface;

/**
 * @copyright  Copyright (c) 2019 TechDivision GmbH (https://www.techdivision.com)
 * @link       https://www.techdivision.com/
 * @author     Lukas Kiederle <l.kiederle@techdivision.com
 */
class ConfirmQuoteCaller implements PspCallerInterface
{
    /**
     * @var DataProvider
     */
    private $dataProvider;

    /**
     * QuoteConfirmer constructor.
     * @param DataProvider $dataProvider
     */
    public function __construct(DataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * @param PspOrderInterface $order
     * @param array $options
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function execute(PspOrderInterface $order, array $options = []): void
    {
        $client = new Client();

        /** @var ResponseInterface $response */
        /** @var Order $order */
        $response = $client->request(
            'POST',
            $order->getResponseUrl(),
            [
                'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
                'verify' => false,
                'form_params' => $this->buildQuoteUrl($order)
            ]
        );

        $order->setRedirectUrl((string)$response->getBody());

        if ($response->getStatusCode() !== 200) {
            throw new \Exception($response->getReasonPhrase());
        }
    }

    /**
     * @param Order $order
     * @return array
     */
    private function buildQuoteUrl(Order $order): array
    {
        return $this->dataProvider->get($order);
    }
}
