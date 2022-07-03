<?php

namespace App\Http\Controllers\Actions\Purchasing;

use Features\Shop\Shop;
use Features\Purchasing\Cart;
use Features\Purchasing\LineItem;
use Features\Customer\CustomerSession;
use Katyusha\Framework\Support\Action;
use Katyusha\Drivers\Payment\PaymentFacade;
use Katyusha\Drivers\Payment\PaymentManager;
use Features\Purchasing\Enums\PaymentProvidersEnum;

/**
 * @method static LineItem run(Shop $shop, PaymentProvidersEnum $paymentMethod)
 */
class CheckoutAction extends Action {
    /**
     * @throws \App\Exceptions\PaymentProviderException
     */
    public function handle(Shop $shop, PaymentProvidersEnum $paymentMethod) {
        $session            = CustomerSession::loadFromRequest();
        $cart               = Cart::getCart($shop, $session);
        $order              = ConvertCartToOrder::run($cart);
        $payment            = CreatePaymentForOrder::run($order, $paymentMethod);
        $apiKeysConsignment = $payment->getApiKeyConsignment();
        $requestConsignment = $payment->getPaymentRequestConsignment();

        return PaymentFacade::stripe($apiKeysConsignment, $requestConsignment)->initiateCheckout();

        return PaymentManager::create($paymentMethod, $apiKeysConsignment, $requestConsignment);
    }
}
