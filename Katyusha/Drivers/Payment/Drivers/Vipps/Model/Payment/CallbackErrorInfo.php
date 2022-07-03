<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class CustomerInfo.
 */
class CallbackErrorInfo
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $errorCode;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $errorGroup;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $errorMessage;

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getErrorGroup(): string
    {
        return $this->errorGroup;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
