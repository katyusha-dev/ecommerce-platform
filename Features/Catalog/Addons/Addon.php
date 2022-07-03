<?php

namespace Features\Catalog\Addons;

use Features\Catalog\Product;
use Features\Catalog\Category;
use Katyusha\Framework\Eloquent\Model;
use Features\Shop\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Addon extends Model {
    use BelongsToShop;

    protected $table = 'catalog.addons';

    public function options(): HasMany {
        return $this->hasMany(AddonOption::class);
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany(Category::class, 'catalog.addon_categories');
    }

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'catalog.addon_products');
    }
}
