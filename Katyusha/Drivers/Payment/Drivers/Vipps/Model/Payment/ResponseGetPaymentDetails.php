<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class ResponseGetPaymentDetails.
 */
class ResponseGetPaymentDetails
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $orderId;

    /**
     * @JMS\Serializer\Annotation\Type("Drivers\Clients\Payments\Vipps\Model\Payment\PaymentShippingDetails")
     */
    protected PaymentShippingDetails $shippingDetails;

    /**
     * @JMS\Serializer\Annotation\Type("Drivers\Clients\Payments\Vipps\Model\Payment\TransactionSummary")
     */
    protected TransactionSummary $transactionSummary;

    /**
     * @var array<TransactionLog>
     *
     * @JMS\Serializer\Annotation\Type("array<Drivers\Clients\Payments\Vipps\Model\Payment\TransactionLog>")
     */
    protected array $transactionLogHistory;

    /**
     * @JMS\Serializer\Annotation\Type("Drivers\Clients\Payments\Vipps\Model\Payment\UserDetails")
     */
    protected UserDetails $userDetails;

    /**
     * Gets orderId value.
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getShippingDetails(): PaymentShippingDetails
    {
        return $this->shippingDetails;
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
     *
     * @return array<TransactionLog>
     */
    public function getTransactionLogHistory(): array
    {
        return $this->transactionLogHistory;
    }

    public function getUserDetails(): UserDetails
    {
        return $this->userDetails;
    }
}
