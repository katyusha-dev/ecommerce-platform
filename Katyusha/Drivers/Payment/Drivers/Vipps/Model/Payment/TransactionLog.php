<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

use DateTimeInterface;

/**
 * Class TransactionLog.
 */
class TransactionLog
{
    /**
     * @JMS\Serializer\Annotation\Type("DateTime<'Y-m-d\TH:i:s.u\Z'>")
     */
    protected DateTimeInterface $timeStamp;

    /**
     * @JMS\Serializer\Annotation\Type("boolean")
     */
    protected string $operationSuccess;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $operation;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $amount;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $transactionId;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $transactionText;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $requestId;

    /**
     * Gets timeStamp value.
     */
    public function getTimeStamp(): DateTimeInterface
    {
        return $this->timeStamp;
    }

    /**
     * Sets timeStamp variable.
     *
     * @return $this
     */
    public function setTimeStamp(DateTimeInterface $timeStamp)
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }

    /**
     * Gets operation value.
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * Sets operation variable.
     *
     * @return $this
     */
    public function setOperation(string $operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Gets operation success value.
     */
    public function getOperationSuccess(): bool
    {
        return $this->operationSuccess;
    }

    /**
     * Sets operation success variable.
     *
     * @return $this
     */
    public function setOperationSuccess(bool $operation)
    {
        $this->operationSuccess = $operation;

        return $this;
    }

    /**
     * Gets amount value.
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Sets amount variable.
     *
     * @return $this
     */
    public function setAmount(int $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Gets transactionId value.
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * Sets transactionId variable.
     *
     * @return $this
     */
    public function setTransactionId(string $transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * Gets transactionText value.
     */
    public function getTransactionText(): string
    {
        return $this->transactionText;
    }

    /**
     * Sets transactionText variable.
     *
     * @return $this
     */
    public function setTransactionText(string $transactionText)
    {
        $this->transactionText = $transactionText;

        return $this;
    }

    /**
     * Gets requestId value.
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * Sets requestId variable.
     *
     * @return $this
     */
    public function setRequestId(string $requestId)
    {
        $this->requestId = $requestId;

        return $this;
    }
}
