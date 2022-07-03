<?php

namespace App\Http\Controllers\Actions\Purchasing;

use Features\Purchasing\Cart;
use Features\Purchasing\Order;
use Katyusha\Framework\Support\Action;

/**
 * @method static Order run(Cart $cart)
 */
class ConvertCartToOrder extends Action
{
    public function handle(Cart $cart): Order
    {
        if ($cart->order) {
            return $cart->order;
        }

        $order = Order::make()
            ->setCartId($cart->getId())
            ->setShopId($cart->getShopId())
            ->setCustomerId($cart->getCustomerId());

        if ($id = $cart->getSessionId()) {
            $order->setSessionId($id);
        }

        $order->save();
        $cart->lineItems()->update(['order_id' => $order->getId()]);

        return $order;
    }
}
