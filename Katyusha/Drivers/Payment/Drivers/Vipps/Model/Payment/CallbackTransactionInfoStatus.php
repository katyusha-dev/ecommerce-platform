<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

use DateTimeInterface;

/**
 * Class CustomerInfo.
 */
class CallbackTransactionInfoStatus
{
    /**
     * @JMS\Serializer\Annotation\Type("double")
     */
    protected float $amount;

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

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getTimeStamp(): DateTimeInterface
    {
        return $this->timeStamp;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }
}
