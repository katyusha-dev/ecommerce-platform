<?php

namespace Features\Catalog\Variables;

use Katyusha\Framework\Eloquent\Model;
use Features\Shop\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model {
    use BelongsToShop;

    public $timestamps = false;
    public $sortable   = ['order_column_name' => 'sort_order', 'sort_when_creating' => true];

    protected $table = 'catalog.options';

    public function optionValues(): HasMany {
        return $this->hasMany(OptionValue::class);
    }
}
