<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource\Payment;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseGetPaymentDetails;
use Katyusha\Drivers\Payment\Drivers\Vipps\Resource\HttpMethod;
use Katyusha\Drivers\Payment\Drivers\Vipps\VippsInterface;
use Psr\Http\Client\ClientExceptionInterface;

class GetPaymentDetails extends PaymentResourceBase
{
    protected mixed $method = HttpMethod::GET;

    protected string $path = '/ecomm/v2/payments/{id}/details';

    /**
     * InitiatePayment constructor.
     */
    public function __construct(VippsInterface $vipps, string $subscription_key, string $order_id)
    {
        parent::__construct($vipps, $subscription_key);
        $this->id = $order_id;
    }

    /**
     * @throws VippsException|ClientExceptionInterface
     */
    public function call(): ResponseGetPaymentDetails
    {
        $response = $this->makeCall();
        $body = $response->getBody()->getContents();

        return $this
            ->getSerializer()
            ->deserialize(
                $body,
                ResponseGetPaymentDetails::class,
                'json'
            );
    }
}
