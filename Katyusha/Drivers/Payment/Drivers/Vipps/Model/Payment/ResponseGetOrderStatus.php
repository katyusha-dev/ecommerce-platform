<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class ResponseGetOrderStatus.
 */
class ResponseGetOrderStatus
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $orderId;

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
     * Gets transactionInfo value.
     */
    public function getTransactionInfo(): TransactionInfo
    {
        return $this->transactionInfo;
    }
}
