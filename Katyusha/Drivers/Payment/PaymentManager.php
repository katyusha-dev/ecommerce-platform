<?php

namespace Katyusha\Drivers\Payment;

use App\Exceptions\CouldNotProvideDriverException;
use Features\Purchasing\Enums\PaymentProvidersEnum;
use Katyusha\Drivers\Payment\Consignments\BamboraApiConsignment;
use Katyusha\Drivers\Payment\Consignments\PaymentRequestConsignment;
use Katyusha\Drivers\Payment\Consignments\StripeApiConsignment;
use Katyusha\Drivers\Payment\Consignments\VippsApiConsignment;
use Katyusha\Drivers\Payment\Contracts\PaymentDriverContract;
use Katyusha\Drivers\Payment\Drivers\StripeDriver;
use Katyusha\Drivers\Payment\Drivers\VippsDriver;
use Katyusha\Framework\Support\Manager;

/**
 * @method static self create(PaymentProvidersEnum $paymentMethod, BamboraApiConsignment | VippsApiConsignment | StripeApiConsignment $apiConsignment, PaymentRequestConsignment $paymentRequestConsignment)
 */
final class PaymentManager extends Manager
{
    /**
     * Just throw an exception. There's no "default" payment method.
     *
     * @throws CouldNotProvideDriverException
     */
    public function getDefaultDriver(): string
    {
        throw new CouldNotProvideDriverException();
    }

    public function createStripeDriver(StripeApiConsignment $apiConsignment, PaymentRequestConsignment $paymentRequestConsignment): PaymentDriverContract
    {
        return new StripeDriver($apiConsignment, $paymentRequestConsignment);
    }

    public function createVippsDriver(VippsApiConsignment $apiConsignment, PaymentRequestConsignment $paymentRequestConsignment): PaymentDriverContract
    {
        return new VippsDriver($apiConsignment, $paymentRequestConsignment);
    }
}
