<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

use DateTimeInterface;

/**
 * Class Transaction.
 */
class Transaction
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $orderId;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $refOrderId;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $amount;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $transactionText;

    /**
     * @JMS\Serializer\Annotation\Type("DateTime<'Y-m-d\TH:i:s.u\Z'>")
     */
    protected ?DateTimeInterface $timeStamp = null;

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
     * Gets orderId value.
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * Sets orderId variable.
     *
     * @return $this
     */
    public function setOrderId(string $orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Gets refOrderId value.
     */
    public function getRefOrderId(): string
    {
        return $this->refOrderId;
    }

    /**
     * Sets refOrderId variable.
     *
     * @return $this
     */
    public function setRefOrderId(string $refOrderId)
    {
        $this->refOrderId = $refOrderId;

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
}
