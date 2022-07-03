<?php

namespace App\Http\Controllers\Actions\Purchasing;

use Features\Purchasing\Enums\PaymentProvidersEnum;
use Features\Purchasing\Order;
use Features\Purchasing\Payment;
use Katyusha\Framework\Support\Action;

/**
 * @method static Payment run(Order $order, PaymentProvidersEnum $provider)
 */
class CreatePaymentForOrder extends Action
{
    public function handle(Order $order, PaymentProvidersEnum $provider): Payment
    {
        if ($activePayment = $order->activePayment) {
            return $activePayment;
        }

        return Payment::make()
            ->setShopId($order->getShopId())
            ->setOrderId($order->getId())
            ->setPaymentMethod($provider)
            ->setAmount($order->total)
            ->setTotalWithoutTax($order->totalWithoutTax)
            ->setTax($order->totalTax)
            ->setCurrency($order->shop->getCurrency())
            ->saveAndReturnModel();
    }
}
