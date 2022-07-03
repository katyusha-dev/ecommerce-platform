<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

use Katyusha\Drivers\Payment\Drivers\Vipps\Model\FromStringInterface;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\FromStringTrait;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\SupportsSerializationInterface;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\ToStringInterface;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\ToStringTrait;

class RegularCheckOutPaymentRequest implements FromStringInterface, ToStringInterface, SupportsSerializationInterface
{
    use FromStringTrait;
    use ToStringTrait;
    use PaymentSerializationTrait;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $merchantSerialNumber;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $orderId;

    /**
     * @JMS\Serializer\Annotation\Type("Drivers\Clients\Payments\Vipps\Model\Payment\CallbackTransactionInfoStatus")
     */
    protected CallbackTransactionInfoStatus $transactionInfo;

    /**
     * @JMS\Serializer\Annotation\Type("Drivers\Clients\Payments\Vipps\Model\Payment\CallbackErrorInfo")
     */
    protected CallbackErrorInfo $errorInfo;

    public function getMerchantSerialNumber(): string
    {
        return $this->merchantSerialNumber;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getTransactionInfo(): CallbackTransactionInfoStatus
    {
        return $this->transactionInfo;
    }

    public function getErrorInfo(): CallbackErrorInfo
    {
        return $this->errorInfo;
    }
}
