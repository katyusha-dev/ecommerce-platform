<?php

namespace Features\Purchasing;

use App\Exceptions\PaymentProviderException;
use Features\Purchasing\Models\PaymentModel;
use Features\Shop\Helpers\ShopApiKeysHelper;
use Katyusha\Drivers\Payment\Consignments\BamboraApiConsignment;
use Katyusha\Drivers\Payment\Consignments\PaymentRequestConsignment;
use Katyusha\Drivers\Payment\Consignments\StripeApiConsignment;
use Katyusha\Drivers\Payment\Consignments\VippsApiConsignment;
use function route;

class Payment extends PaymentModel
{
    /**
     * @throws PaymentProviderException
     */
    public function getApiKeyConsignment(): BamboraApiConsignment | VippsApiConsignment | StripeApiConsignment
    {
        return ShopApiKeysHelper::getPaymentProviderConsignment($this->shop, $this->getPaymentMethod());
    }

    public function getPaymentRequestConsignment(): PaymentRequestConsignment
    {
        $shop = $this->shop;

        return PaymentRequestConsignment::make()
            ->setPaymentId($this->getId())
            ->setNumericPaymentId($this->numeric_id)
            ->setCustomerMobile($this->customer->getMobileNumber())
            ->setCurrency($this->currency)
            ->setAmount($this->amount)
            ->setShopName($shop->getName())
            ->setCallbackUrl(route('payment.callback', $this->id))
            ->setFailureUrl(route('payment.failure', $this->id))
            ->setSuccessUrl(route('payment.success', $this->id));
    }
}
