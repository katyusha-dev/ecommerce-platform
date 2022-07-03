<?php

namespace Features\Catalog\Models;

use Features\Shop\Traits\BelongsToShop;
use Katyusha\Framework\Eloquent\Builder;
use Katyusha\Framework\Eloquent\Collection;
use Katyusha\Framework\Eloquent\Model;
use Katyusha\Framework\Eloquent\ModelTraits\HasNamespace;

class TagModel extends Model
{
    use BelongsToShop;
    use HasNamespace;

    protected $table = 'catalog.tags';

    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }
}
