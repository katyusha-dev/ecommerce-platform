<?php

namespace Katyusha\Drivers\Payment;

use Illuminate\Support\Facades\Facade;
use Katyusha\Drivers\Payment\Consignments\PaymentRequestConsignment;
use Katyusha\Drivers\Payment\Consignments\StripeApiConsignment;
use Katyusha\Drivers\Payment\Drivers\StripeDriver;

class PaymentFacade extends Facade
{
    public static function stripe(StripeApiConsignment $apiConsignment, PaymentRequestConsignment $paymentRequestConsignment): StripeDriver
    {
        return static::$app['payment']->createStripeDriver($apiConsignment, $paymentRequestConsignment);
    }
    protected static function getFacadeAccessor()
    {
        return 'payment';
    }
}
