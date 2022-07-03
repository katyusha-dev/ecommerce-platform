<?php

namespace Features\Catalog\Variables;

use Katyusha\Framework\Eloquent\Model;
use Features\Shop\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionValue extends Model {
    use BelongsToShop;
    public $timestamps = false;
    public $sortable   = ['order_column_name' => 'sort_order', 'sort_when_creating' => true];

    protected $table = 'catalog.option_values';

    public function option(): BelongsTo {
        return $this->belongsTo(Option::class);
    }
}
