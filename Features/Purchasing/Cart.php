<?php

namespace Features\Purchasing;

use Features\Customer\CustomerSession;
use Features\Purchasing\Models\CartModel;
use Features\Shop\Shop;

class Cart extends CartModel
{
    public static function loadOrCreateCart(Shop $shop, CustomerSession $session): static
    {
        if ($cart = static::getCart($shop, $session)) {
            return $cart;
        }

        return static::make()->setCustomerId($session->getCustomerId())->setShopId($shop->id)->setSessionId($session->id)->saveAndReturnModel();
    }

    public static function getCart(Shop $shop, CustomerSession $session): ?static
    {
        if ($cart = static::where('shop_id', $shop->id)->where('session_id', $session->id)->first()) {
            return $cart;
        }

        return null;
    }
}
