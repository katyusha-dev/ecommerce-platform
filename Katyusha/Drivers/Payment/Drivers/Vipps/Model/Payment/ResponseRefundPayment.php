<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class ResponseRefundPayment.
 */
class ResponseRefundPayment
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $orderId;

    /**
     * @JMS\Serializer\Annotation\Type("Drivers\Clients\Payments\Vipps\Model\Payment\TransactionSummary")
     */
    protected TransactionSummary $transactionSummary;

    /**
     * @JMS\Serializer\Annotation\Type("Drivers\Clients\Payments\Vipps\Model\Payment\TransactionInfo")
     */
    protected TransactionInfo $transactionInfo;

    /**
     * Gets orderId value.
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * Gets transactionSummary value.
     */
    public function getTransactionSummary(): TransactionSummary
    {
        return $this->transactionSummary;
    }

    /**
     * Gets transactionLogHistory value.
     */
    public function getTransactionInfo(): TransactionInfo
    {
        return $this->transactionInfo;
    }
}
