<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource\Payment;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\RequestInitiatePayment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseInitiatePayment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Resource\HttpMethod;
use Katyusha\Drivers\Payment\Drivers\Vipps\VippsInterface;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class InitiatePayment.
 */
class InitiatePayment extends PaymentResourceBase
{
    protected mixed $method = HttpMethod::POST;
    protected string $path = '/ecomm/v2/payments';

    /**
     * InitiatePayment constructor.
     */
    public function __construct(VippsInterface $vipps, string $subscription_key, RequestInitiatePayment $requestObject)
    {
        parent::__construct($vipps, $subscription_key);
        $this->body = $this
            ->getSerializer()
            ->serialize(
                $requestObject,
                'json'
            );
    }

    /**
     * @throws VippsException|ClientExceptionInterface
     */
    public function call(): ResponseInitiatePayment
    {
        $response = $this->makeCall();
        $body = $response->getBody()->getContents();

        return $this
            ->getSerializer()
            ->deserialize(
                $body,
                ResponseInitiatePayment::class,
                'json'
            );
    }
}
