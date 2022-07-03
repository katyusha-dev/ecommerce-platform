<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Api;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Authorization\ResponseGetToken;
use Katyusha\Drivers\Payment\Drivers\Vipps\Resource\Authorization\GetToken;
use Psr\Http\Client\ClientExceptionInterface;

class Authorization extends ApiBase implements AuthorizationInterface
{
    /**
     * @throws ClientExceptionInterface
     * @throws VippsException
     */
    public function getToken(string $client_secret): ResponseGetToken
    {
        $resource = new GetToken($this->app, $this->getSubscriptionKey(), $client_secret);
        $response = $resource->call();
        $this->app->getClient()->getTokenStorage()->set($response);

        return $response;
    }
}
