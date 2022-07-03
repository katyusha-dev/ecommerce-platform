<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource\Payment;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\RequestRefundPayment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseRefundPayment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Resource\HttpMethod;
use Katyusha\Drivers\Payment\Drivers\Vipps\VippsInterface;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class RefundPayment.
 */
class RefundPayment extends PaymentResourceBase
{
    protected mixed $method = HttpMethod::POST;

    protected string $path = '/ecomm/v2/payments/{id}/refund';

    /**
     * InitiatePayment constructor.
     */
    public function __construct(
        VippsInterface $vipps,
        string $subscription_key,
        string $order_id,
        RequestRefundPayment $requestObject
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
    public function call(): ResponseRefundPayment
    {
        $response = $this->makeCall();
        $body = $response->getBody()->getContents();

        return $this
            ->getSerializer()
            ->deserialize(
                $body,
                ResponseRefundPayment::class,
                'json'
            );
    }
}
