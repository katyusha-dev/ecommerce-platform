<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource\Payment;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\RequestCapturePayment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseCapturePayment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Resource\HttpMethod;
use Katyusha\Drivers\Payment\Drivers\Vipps\VippsInterface;
use Psr\Http\Client\ClientExceptionInterface as ClientExceptionInterfaceAlias;

/**
 * Class CapturePayment.
 */
class CapturePayment extends PaymentResourceBase
{
    protected mixed $method = HttpMethod::POST;

    protected string $path = '/ecomm/v2/payments/{id}/capture';

    /**
     * InitiatePayment constructor.
     */
    public function __construct(
        VippsInterface $vipps,
        string $subscription_key,
        string $order_id,
        RequestCapturePayment $requestObject
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
     * @throws VippsException|ClientExceptionInterfaceAlias
     */
    public function call(): ResponseCapturePayment
    {
        $response = $this->makeCall();
        $body = $response->getBody()->getContents();

        return $this
            ->getSerializer()
            ->deserialize(
                $body,
                ResponseCapturePayment::class,
                'json'
            );
    }
}
