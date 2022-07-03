<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class CustomerInfo.
 */
class CustomerInfo
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected ?string $mobileNumber = null;

    /**
     * Gets mobileNumber value.
     */
    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    /**
     * Sets mobileNumber variable.
     *
     * @return $this
     */
    public function setMobileNumber(string $mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }
}
