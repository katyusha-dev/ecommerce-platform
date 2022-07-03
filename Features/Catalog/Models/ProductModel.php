<?php

namespace Features\Catalog\Models;

use Features\Catalog\Tag;
use Features\Fees\TaxRate;
use Features\Catalog\Category;
use Features\Catalog\Stock\Stock;
use Features\Catalog\Variables\Option;
use Katyusha\Framework\Eloquent\Model;
use Features\Shop\Traits\BelongsToShop;
use Katyusha\Framework\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Features\Catalog\Eloquent\Builders\ProductBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Katyusha\Framework\Eloquent\ModelTraits\HasNamespace;
use Features\Catalog\Eloquent\SettersAndGetters\ProductModelSettersAndGetters;

/**
 * @property string shop_id
 * @property string name
 * @property string namespace
 * @property bool active
 * @property ?float cost_price
 * @property float price
 * @property ?float sale_price
 * @property ?Carbon sale_date_from
 * @property ?Carbon sale_date_to
 * @property ?string sku
 * @property ?string image_id
 * @property ?int sort_order
 * @property bool featured
 * @property bool hidden
 * @property ?string image
 * @property string gallery
 * @property ?string description
 * @property ?string product_grid_description
 * @property ?int stock
 * @property bool manage_stock
 * @property bool hide_when_out_of_stock
 * @property ?int external_id
 * @property Collection|Category[] categories
 *
 * @method static ProductBuilder whereExternalId(int $id)
 */
class ProductModel extends Model {
    use BelongsToShop;
    use HasNamespace;
    use ProductModelSettersAndGetters;
    public $sortable = ['order_column_name' => 'sort_order', 'sort_when_creating' => true];
    public $casts    = ['gallery' => 'json', 'price' => 'int', 'sale_price' => 'int'];

    protected $table = 'catalog.products';

    public function newCollection(array $models = []): Collection {
        return new Collection($models);
    }

    public function newEloquentBuilder($query): ProductBuilder {
        return new ProductBuilder($query);
    }

    public function taxRate(): BelongsTo {
        return $this->belongsTo(TaxRate::class);
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany(Category::class, 'product_groupings.product_categories');
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class, 'catalog.product_tags');
    }

    public function options(): BelongsToMany {
        return $this->belongsToMany(Option::class, 'catalog.product_options');
    }
}
