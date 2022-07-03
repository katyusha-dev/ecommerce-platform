<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

use Katyusha\Drivers\Payment\Drivers\Vipps\Model\SupportsSerializationInterface;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\ToStringInterface;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\ToStringTrait;

class FetchShippingCostResponse implements ToStringInterface, SupportsSerializationInterface
{
    use PaymentSerializationTrait;
    use ToStringTrait;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $addressId;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $orderId;

    /**
     * @var array<ShippingDetails>
     *
     * @JMS\Serializer\Annotation\Type("array<Drivers\Clients\Payments\Vipps\Model\Payment\ShippingDetails>")
     */
    protected array $shippingDetails;

    public function getAddressId(): int
    {
        return $this->addressId;
    }

    /**
     * @return $this
     */
    public function setAddressId(int $addressId)
    {
        $this->addressId = $addressId;

        return $this;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return $this
     */
    public function setOrderId(string $orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return array<ShippingDetails>
     */
    public function getShippingDetails(): array
    {
        return $this->shippingDetails;
    }

    /**
     * @param array<ShippingDetails> $shippingDetails
     *
     * @return $this
     */
    public function setShippingDetails(array $shippingDetails)
    {
        $this->shippingDetails = $shippingDetails;

        return $this;
    }
}
