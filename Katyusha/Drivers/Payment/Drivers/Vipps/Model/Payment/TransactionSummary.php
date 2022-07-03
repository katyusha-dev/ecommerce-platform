<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class TransactionSummary.
 */
class TransactionSummary
{
    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $capturedAmount;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $remainingAmountToCapture;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $refundedAmount;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $remainingAmountToRefund;

    /**
     * Gets capturedAmount value.
     */
    public function getCapturedAmount(): int
    {
        return $this->capturedAmount;
    }

    /**
     * Sets capturedAmount variable.
     *
     * @return $this
     */
    public function setCapturedAmount(int $capturedAmount)
    {
        $this->capturedAmount = $capturedAmount;

        return $this;
    }

    /**
     * Gets remainingAmountToCapture value.
     */
    public function getRemainingAmountToCapture(): int
    {
        return $this->remainingAmountToCapture;
    }

    /**
     * Sets remainingAmountToCapture variable.
     *
     * @return $this
     */
    public function setRemainingAmountToCapture(int $remainingAmountToCapture)
    {
        $this->remainingAmountToCapture = $remainingAmountToCapture;

        return $this;
    }

    /**
     * Gets refundedAmount value.
     */
    public function getRefundedAmount(): int
    {
        return $this->refundedAmount;
    }

    /**
     * Sets refundedAmount variable.
     *
     * @return $this
     */
    public function setRefundedAmount(int $refundedAmount)
    {
        $this->refundedAmount = $refundedAmount;

        return $this;
    }

    /**
     * Gets remainingAmountToRefund value.
     */
    public function getRemainingAmountToRefund(): int
    {
        return $this->remainingAmountToRefund;
    }

    /**
     * Sets remainingAmountToRefund variable.
     *
     * @return $this
     */
    public function setRemainingAmountToRefund(int $remainingAmountToRefund)
    {
        $this->remainingAmountToRefund = $remainingAmountToRefund;

        return $this;
    }
}
