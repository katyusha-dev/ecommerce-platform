<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

use DateTimeInterface;

/**
 * Class TransactionInfo.
 */
class TransactionInfo
{
    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $amount;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $status;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $transactionId;

    /**
     * @JMS\Serializer\Annotation\Type("DateTime<'Y-m-d\TH:i:s.u\Z'>")
     */
    protected DateTimeInterface $timeStamp;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $transactionText;

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
     * Gets message value.
     */
    public function getTransactionText(): string
    {
        return $this->transactionText;
    }

    /**
     * Sets message variable.
     *
     * @return $this
     */
    public function setTransactionText(string $message)
    {
        $this->transactionText = $message;

        return $this;
    }

    /**
     * Gets status value.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Sets status variable.
     *
     * @return $this
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

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
}
