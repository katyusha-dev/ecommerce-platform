<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class MerchantInfo.
 */
class PaymentShippingDetails
{
    /**
     * @JMS\Serializer\Annotation\Type("Drivers\Clients\Payments\Vipps\Model\Payment\Address")
     */
    protected Address $address;

    /**
     * @JMS\Serializer\Annotation\Type("double")
     */
    protected float $shippingCost;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $shippingMethod;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $shippingMethodId;

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getShippingCost(): float
    {
        return $this->shippingCost;
    }

    public function getShippingMethod(): string
    {
        return $this->shippingMethod;
    }

    public function getShippingMethodId(): string
    {
        return $this->shippingMethodId;
    }
}
