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
class RedirectCaller implements PspCallerInterface
{
    /**
     * @var array
     */
    private $defaultOptions = [
        'verify' => false
    ];

    /**
     * @param PspOrderInterface $order
     * @param array $options
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute(PspOrderInterface $order, array $options = []): void
    {
        $client = new Client(['defaults' => [
            'verify' => false
        ]]);

        /** @var ResponseInterface $response */
        /** @var Order $order */
        $response = $client->request(
            'POST',
            $order->getRedirectUrl(),
            array_merge($this->defaultOptions, $options)
        );

        if ($response->getStatusCode() !== 200) {
            throw new \Exception($response->getReasonPhrase());
        }
    }
}
