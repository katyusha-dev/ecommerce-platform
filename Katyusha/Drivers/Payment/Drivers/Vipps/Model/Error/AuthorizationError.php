<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Error;

use DateTimeInterface;
use function Drivers\Clients\Payments\Vipps\Model\Error\implode;

class AuthorizationError implements ErrorInterface
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $error;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $errorDescription;

    /**
     * @JMS\Serializer\Annotation\Type("array")
     */
    protected array $errorCodes;

    /**
     * @JMS\Serializer\Annotation\Type("DateTime<'Y-m-d H:i:s\Z'>")
     */
    protected DateTimeInterface $timestamp;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $traceId;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $correlationId;

    /**
     * Gets error value.
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * Gets errorDescription value.
     */
    public function getErrorDescription(): string
    {
        return $this->errorDescription;
    }

    /**
     * Gets errorCodes value.
     */
    public function getErrorCodes(): array
    {
        return $this->errorCodes;
    }

    /**
     * Gets timestamp value.
     */
    public function getTimestamp(): DateTimeInterface
    {
        return $this->timestamp;
    }

    /**
     * Gets traceId value.
     */
    public function getTraceId(): string
    {
        return $this->traceId;
    }

    /**
     * Gets correlationId value.
     */
    public function getCorrelationId(): string
    {
        return $this->correlationId;
    }

    public function getCode(): string
    {
        return implode(',', $this->getErrorCodes());
    }

    public function getMessage(): string
    {
        return $this->getErrorDescription();
    }
}
