<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Error;

use JMS\Serializer\Annotation as Serializer;

class PaymentError implements ErrorInterface
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     *
     * @Serializer\SerializedName("errorGroup")
     */
    protected string $errorGroup;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     *
     * @Serializer\SerializedName("errorCode")
     */
    protected string $errorCode;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     *
     * @Serializer\SerializedName("errorMessage")
     */
    protected string $errorMessage;

    /**
     * Gets errorCode value.
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * Gets errorGroup value.
     */
    public function getErrorGroup(): string
    {
        return $this->errorGroup;
    }

    /**
     * Gets errorMessage value.
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getCode(): string
    {
        return $this->getErrorCode();
    }

    public function getMessage(): string
    {
        return $this->getErrorMessage();
    }
}
