<?php

namespace App\Http\Controllers\Actions\Purchasing;

use Features\Customer\CustomerSession;
use Features\Purchasing\Cart;
use Features\Shop\Shop;
use Katyusha\Framework\Support\Action;

/**
 * @method static Cart run(Shop $shop)
 */
class InitializeCartAction extends Action
{
    public static function handle(Shop $shop): Cart
    {
        $session = CustomerSession::loadFromRequest();

        return Cart::loadOrCreateCart($shop, $session);
    }
}
