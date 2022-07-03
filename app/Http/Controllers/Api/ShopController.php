<?php

namespace App\Http\Controllers\Api;

use function response;
use Features\Shop\Shop;
use App\Http\Controllers\ApiController;

class ShopController extends ApiController {
    public function logo(Shop $shop) {
        return response()->file($shop->getLogoPath());
    }
}
