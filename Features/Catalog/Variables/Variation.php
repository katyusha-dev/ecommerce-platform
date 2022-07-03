<?php

namespace Features\Catalog\Variables;

use Features\Shop\Shop;
use Features\Catalog\Product;
use Katyusha\Framework\Eloquent\Model;
use Features\Shop\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Variation extends Model {
    use BelongsToShop;

    public $timestamps = false;
    public $sortable   = ['order_column_name' => 'sort_order', 'sort_when_creating' => true];

    protected $table = 'catalog.variations';

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function shop(): BelongsTo {
        return $this->belongsTo(Shop::class);
    }

    public function options(): BelongsToMany {
        return $this->belongsToMany(Option::class, 'catalog.variation_option_values');
    }

    public function optionValues(): BelongsToMany {
        return $this->belongsToMany(OptionValue::class, 'catalog.variation_option_values');
    }
}
