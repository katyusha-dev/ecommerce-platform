<?php

namespace App\Http\Controllers\Integrations\WooCommerce;

use App\Api\Action;
use App\Applications\Shops\App\Shop;

/**
 * @method static bool run(Shop $shop)
 */
class TestShopWooCommerceIntegration extends Action
{
    public function handle(Shop $shop): bool
    {
        if (! $shop->wooCommerce) {
            return false;
        }
        $shop->wooCommerce->setApiData();

        return true;
    }
}
