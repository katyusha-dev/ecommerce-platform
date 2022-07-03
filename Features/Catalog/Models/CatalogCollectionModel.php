<?php

namespace Features\Catalog\Models;

use Features\Catalog\Product;
use Features\Shop\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Katyusha\Framework\Eloquent\Builder;
use Katyusha\Framework\Eloquent\Collection;
use Katyusha\Framework\Eloquent\Model;
use Katyusha\Framework\Eloquent\ModelTraits\HasNamespace;

class CatalogCollectionModel extends Model
{
    use BelongsToShop;
    use HasNamespace;

    protected $table = 'product_groupings.collections';
    protected $with = ['products'];

    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'catalog.collection_products');
    }
}
