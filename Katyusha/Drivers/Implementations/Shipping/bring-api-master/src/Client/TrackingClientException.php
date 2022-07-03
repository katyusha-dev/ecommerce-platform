<?php

namespace Trafficfox\Bring\API\Client;

use Exception;

class TrackingClientException extends Exception
{
    /**
     * The http exception.
     */
    public function getRequestException(): \GuzzleHttp\Exception\RequestException
    {
        return $this->getPrevious();
    }
}
