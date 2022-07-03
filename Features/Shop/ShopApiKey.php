<?php

namespace Features\Shop;

use Katyusha\Framework\Eloquent\Model;
use Features\Shop\Traits\BelongsToShop;

class ShopApiKey extends Model {
    use BelongsToShop;

    protected $table   = 'shop.api_keys';
    public $timestamps = false;
}
