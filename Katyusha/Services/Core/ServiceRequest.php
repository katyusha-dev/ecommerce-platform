<?php

namespace Katyusha\Services\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class ServiceRequest
{
    public Client $client;

    public function request(): Response
    {
    }
}
