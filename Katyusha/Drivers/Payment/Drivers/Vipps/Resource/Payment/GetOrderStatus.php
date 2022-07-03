<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource\Payment;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseGetOrderStatus;
use Katyusha\Drivers\Payment\Drivers\Vipps\Resource\HttpMethod;
use Katyusha\Drivers\Payment\Drivers\Vipps\VippsInterface;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class GetOrderStatus.
 *
 *   This API call allows the merchant to get the status of the last payment transaction.
 *   Primarily use of this service is meant for inApp where simple response to check order
 *   status is preferred.
 */
class GetOrderStatus extends PaymentResourceBase
{
    protected mixed $method = HttpMethod::GET;

    protected string $path = '/ecomm/v2/payments/{id}/status';

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
    public function call(): ResponseGetOrderStatus
    {
        $response = $this->makeCall();
        $body = $response->getBody()->getContents();

        return $this
            ->getSerializer()
            ->deserialize(
                $body,
                ResponseGetOrderStatus::class,
                'json'
            );
    }
}
