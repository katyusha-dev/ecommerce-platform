<?php

/**
 * Vipps interface.
 *
 * Provide Vipps client interface.
 */

namespace Katyusha\Drivers\Payment\Drivers\Vipps;

use Katyusha\Drivers\Payment\Drivers\Vipps\Api\Authorization;
use Katyusha\Drivers\Payment\Drivers\Vipps\Api\Payment;

/**
 * Interface VippsInterface.
 */
interface VippsInterface
{
    public function getClient(): ClientInterface;

    public function authorization(string $subscription_key): Authorization;

    public function payment(string $subscription_key, string $merchant_serial_number, string $custom_path): Payment;
}
