<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

class ShippingDetails
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $isDefault;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $priority;

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

    public function getIsDefault(): string
    {
        return $this->isDefault;
    }

    /**
     * @return $this
     */
    public function setIsDefault(string $isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return $this
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function getShippingCost(): float
    {
        return $this->shippingCost;
    }

    /**
     * @return $this
     */
    public function setShippingCost(float $shippingCost)
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    public function getShippingMethod(): string
    {
        return $this->shippingMethod;
    }

    /**
     * @return $this
     */
    public function setShippingMethod(string $shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;

        return $this;
    }

    public function getShippingMethodId(): string
    {
        return $this->shippingMethodId;
    }

    /**
     * @return $this
     */
    public function setShippingMethodId(string $shippingMethodId)
    {
        $this->shippingMethodId = $shippingMethodId;

        return $this;
    }
}
