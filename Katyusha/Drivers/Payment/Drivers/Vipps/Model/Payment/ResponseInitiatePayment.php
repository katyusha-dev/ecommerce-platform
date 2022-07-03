<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class ResponseInitiatePayment.
 */
class ResponseInitiatePayment
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $orderId;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $url;

    /**
     * Gets orderId value.
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * Gets URL  value.
     */
    public function getURL(): string
    {
        return $this->url;
    }
}
