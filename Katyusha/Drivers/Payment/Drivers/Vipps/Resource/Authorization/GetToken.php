<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource\Authorization;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Authorization\ResponseGetToken;
use Katyusha\Drivers\Payment\Drivers\Vipps\Resource\HttpMethod;
use Katyusha\Drivers\Payment\Drivers\Vipps\Resource\ResourceBase;
use Katyusha\Drivers\Payment\Drivers\Vipps\VippsInterface;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class GetToken.
 */
class GetToken extends ResourceBase
{
    protected mixed $method = HttpMethod::POST;
    protected string $path = '/accessToken/get';

    /**
     * GetToken constructor.
     */
    public function __construct(VippsInterface $vipps, string $subscription_key, string $client_secret)
    {
        parent::__construct($vipps, $subscription_key);
        // Authorization module requires client_id to be set on "client_id"
        // header.

        $this->headers['client_id'] = $this->app->getClient()->getClientId();
        $this->headers['client_secret'] = $client_secret;
    }

    /**
     * @throws VippsException|ClientExceptionInterface
     */
    public function call(): ResponseGetToken
    {
        $response = $this->makeCall();

        return $this
            ->getSerializer()
            ->deserialize(
                $response->getBody()->getContents(),
                ResponseGetToken::class,
                'json'
            );
    }
}
