<?php

namespace Katyusha\Drivers\Payment\Consignments;

class VippsApiConsignment
{
    public function __construct(public string $clientId, public string $clientSecret, public int $merchantSerialNumber, public string $ecommerceSubscriptionKey, public bool $productionMode = true)
    {
    }
}
