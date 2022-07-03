<?php

namespace Features\Catalog\Models;

use Features\Fees\TaxRate;
use Features\Catalog\Product;
use Katyusha\Framework\Eloquent\Model;
use Features\Shop\Traits\BelongsToShop;
use Katyusha\Framework\Eloquent\Builder;
use Katyusha\Framework\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Katyusha\Framework\Eloquent\ModelTraits\HasNamespace;
use Features\Catalog\Models\Attributes\CategoryModelGetterAndSetters;

/**
 * @property string name
 * @property bool active
 * @property string description
 * @property string top_description
 * @property string bottom_text
 * @property string parent_id
 * @property string imported_parent_id
 * @property int imported_id
 * @property int sort_order
 * @property string image
 * @property string icon
 * @property Product[]|Collection products
 *
 * @method static Builder whereImportedId(int $id)
 */
class CategoryModel extends Model {
    use CategoryModelGetterAndSetters;
    use BelongsToShop;
    use HasNamespace;

    public $sortable = ['order_column_name' => 'sort_order', 'sort_when_creating' => true];
    protected $table = 'product_groupings.categories';

    public function newCollection(array $models = []): Collection {
        return new Collection($models);
    }

    public function newEloquentBuilder($query): Builder {
        return new Builder($query);
    }

    public function taxRate(): BelongsTo {
        return $this->belongsTo(TaxRate::class);
    }

    public function parent(): BelongsTo {
        return $this->belongsTo(static::class);
    }

    public function children(): HasMany {
        return $this->hasMany(static::class, 'parent_id')->with('products');
    }

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'product_groupings.product_categories');
    }
}
