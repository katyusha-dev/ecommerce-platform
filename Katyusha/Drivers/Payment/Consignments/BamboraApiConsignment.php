<?php

namespace Katyusha\Drivers\Payment\Consignments;

class BamboraApiConsignment
{
    public function __construct(public string $accessToken, public string $merchantNumber, public string $secretToken)
    {
    }
}
