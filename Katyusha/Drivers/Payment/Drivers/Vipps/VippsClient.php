<?php

/**
 * Vipps class.
 *
 * Vipps client handles all requests, has built in factories for all resources.
 */

namespace Katyusha\Drivers\Payment\Drivers\Vipps;

use Katyusha\Drivers\Payment\Drivers\Vipps\Api\Authorization;
use Katyusha\Drivers\Payment\Drivers\Vipps\Api\Payment;

/**
 * Class Vipps.
 */
class VippsClient implements VippsInterface
{
    protected ClientInterface $client;

    /**
     * Vipps constructor.
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function payment(string $subscription_key, string $merchant_serial_number, string $custom_path = 'ecomm'): Payment
    {
        return new Payment($this, $subscription_key, $merchant_serial_number, $custom_path);
    }

    public function authorization(string $subscription_key): Authorization
    {
        return new Authorization($this, $subscription_key);
    }
}
