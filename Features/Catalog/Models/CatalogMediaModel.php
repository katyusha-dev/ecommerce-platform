<?php

namespace Features\Catalog\Models;

use Features\Shop\Traits\BelongsToShop;
use Katyusha\Framework\Eloquent\Builder;
use Katyusha\Framework\Eloquent\Collection;
use Katyusha\Framework\Eloquent\Model;

class CatalogMediaModel extends Model
{
    use BelongsToShop;
    protected $table = 'catalog.media';

    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }
}
