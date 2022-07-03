<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class CustomerInfo.
 */
class Address
{
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
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $postCode;

    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    public function getAddressLine2(): string
    {
        return $this->addressLine2;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }
}
