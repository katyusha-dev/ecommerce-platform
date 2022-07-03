<?php

namespace Katyusha\Drivers\Payment\Consignments;

use Katyusha\Framework\Money;
use Katyusha\Framework\Traits\Makeable;

/**
 * Hold the values required to start the checkout process.
 * It should contain the information the API of whichever provider as well as basic order information.
 */
class PaymentRequestConsignment
{
    use Makeable;

    /** The UUID of the order */
    public string $paymentId;

    /** The numeric ID of the order, as some providers want a number */
    public int $numericPaymentId;

    /** Ducks */
    public int $customerMobile;

    /** Uppercase but some providers want it lowercase so strtolower it there */
    public string $currency;

    /** Total amount payable */
    public Money $amount;

    /** Some providers ask for this */
    public string $shopName;

    /** Where to send the customer on success */
    public string $successUrl;

    /** Where to send the customer on failure */
    public string $failureUrl;

    /** Server-to-server callback, containing information about the order */
    public string $callbackUrl;

    public function __construct()
    {
//        $this->apiConsignment   = $order->shop->($order->getPaymentMethod());
//        $this->currency          = 'NOK';
//        $this->amount            = $order->getTotalAttribute();
//        $this->shopName          = $order->shop->getName();
//        $this->successUrl        = $order->shop->getUrlAttribute('#success');
//        $this->failureUrl        = $order->shop->getUrlAttribute('#failure');
//        $this->callbackUrl       = getBasePaymentCallbackUrl().$order->getId();
//        $this->orderId           = $order->getId();
//        $this->numericOrderId    = $order->getNumericId();
//        $this->customerMobile    = $order->profile->getMobile();
    }

    public function setPaymentId(string $paymentId): self
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    public function setNumericPaymentId(int $numericPaymentId): self
    {
        $this->numericPaymentId = $numericPaymentId;

        return $this;
    }

    public function setCustomerMobile(int $customerMobile): self
    {
        $this->customerMobile = $customerMobile;

        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function setAmount(Money $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function setShopName(string $shopName): self
    {
        $this->shopName = $shopName;

        return $this;
    }

    public function setSuccessUrl(string $successUrl): self
    {
        $this->successUrl = $successUrl;

        return $this;
    }

    public function setFailureUrl(string $failureUrl): self
    {
        $this->failureUrl = $failureUrl;

        return $this;
    }

    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->callbackUrl = $callbackUrl;

        return $this;
    }
}
