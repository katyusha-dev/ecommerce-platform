<?php

namespace Katyusha\Drivers\Payment\Consignments;

class StripeApiConsignment
{
    public function __construct(public bool $testMode, public string $publishableKey, public string $secretKey)
    {
    }
}
