<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class RequestInitiatePayment.
 */
class RequestInitiatePayment
{
    /**
     * @JMS\Serializer\Annotation\Type("Drivers\Clients\Payments\Vipps\Model\Payment\MerchantInfo")
     */
    protected MerchantInfo $merchantInfo;

    /**
     * @JMS\Serializer\Annotation\Type("Drivers\Clients\Payments\Vipps\Model\Payment\CustomerInfo")
     */
    protected CustomerInfo $customerInfo;

    /**
     * @JMS\Serializer\Annotation\Type("Drivers\Clients\Payments\Vipps\Model\Payment\Transaction")
     */
    protected Transaction $transaction;

    /**
     * Gets merchantInfo value.
     */
    public function getMerchantInfo(): MerchantInfo
    {
        return $this->merchantInfo;
    }

    /**
     * Sets merchantInfo variable.
     *
     * @return $this
     */
    public function setMerchantInfo(MerchantInfo $merchantInfo)
    {
        $this->merchantInfo = $merchantInfo;

        return $this;
    }

    /**
     * Gets customerInfo value.
     */
    public function getCustomerInfo(): CustomerInfo
    {
        return $this->customerInfo;
    }

    /**
     * Sets customerInfo variable.
     *
     * @return $this
     */
    public function setCustomerInfo(CustomerInfo $customerInfo)
    {
        $this->customerInfo = $customerInfo;

        return $this;
    }

    /**
     * Gets transaction value.
     */
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    /**
     * Sets transaction variable.
     *
     * @return $this
     */
    public function setTransaction(Transaction $transaction)
    {
        $this->transaction = $transaction;

        return $this;
    }
}
