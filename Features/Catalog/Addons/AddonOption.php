<?php

namespace Features\Catalog\Addons;

use Katyusha\Framework\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddonOption extends Model {
    public $sortable = ['order_column_name' => 'sort_order', 'sort_when_creating' => true];

    protected $table = 'catalog.addon_options';

    public function addon(): BelongsTo {
        return $this->belongsTo(Addon::class);
    }
}
