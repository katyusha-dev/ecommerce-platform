<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource\Payment;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\RequestCancelPayment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseCancelPayment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Resource\HttpMethod;
use Katyusha\Drivers\Payment\Drivers\Vipps\VippsInterface;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CancelPayment.
 */
class CancelPayment extends PaymentResourceBase
{
    protected mixed $method = HttpMethod::PUT;

    protected string $path = '/ecomm/v2/payments/{id}/cancel';

    /**
     * InitiatePayment constructor.
     */
    public function __construct(
        VippsInterface $vipps,
        string $subscription_key,
        string $order_id,
        RequestCancelPayment $requestObject
    ) {
        parent::__construct($vipps, $subscription_key);
        $this->body = $this
            ->getSerializer()
            ->serialize(
                $requestObject,
                'json'
            );
        $this->id = $order_id;
    }

    /**
     * @throws VippsException|ClientExceptionInterface
     */
    public function call(): ResponseCancelPayment
    {
        $response = $this->makeCall();
        $body = $response->getBody()->getContents();
        /** @var ResponseCancelPayment $responseObject */
        return $this
            ->getSerializer()
            ->deserialize(
                $body,
                ResponseCancelPayment::class,
                'json'
            );
    }
}
