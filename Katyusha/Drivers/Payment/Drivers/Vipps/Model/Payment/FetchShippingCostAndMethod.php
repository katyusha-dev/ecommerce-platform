<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

use Katyusha\Drivers\Payment\Drivers\Vipps\Model\FromStringInterface;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\FromStringTrait;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\SupportsSerializationInterface;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\ToStringInterface;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\ToStringTrait;

class FetchShippingCostAndMethod implements FromStringInterface, ToStringInterface, SupportsSerializationInterface
{
    use FromStringTrait;
    use PaymentSerializationTrait;
    use ToStringTrait;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $addressId;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $addressLine1;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $addressLine2;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $city;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $country;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $postCode;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $postalCode;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $addressType;

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

    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    /**
     * @return $this
     */
    public function setAddressLine1(string $addressLine1)
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    public function getAddressLine2(): string
    {
        return $this->addressLine2;
    }

    /**
     * @return $this
     */
    public function setAddressLine2(string $addressLine2)
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return $this
     */
    public function setCity(string $city)
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return $this
     */
    public function setCountry(string $country)
    {
        $this->country = $country;

        return $this;
    }

    public function getPostCode(): int
    {
        return $this->postCode;
    }

    /**
     * @return $this
     */
    public function setPostCode(int $postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getPostalCode(): int
    {
        return $this->postalCode;
    }

    /**
     * @return $this
     */
    public function setPostalCode(int $postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getAddressType(): string
    {
        return $this->addressType;
    }

    /**
     * @return $this
     */
    public function setAddressType(string $addressType)
    {
        $this->addressType = $addressType;

        return $this;
    }
}
