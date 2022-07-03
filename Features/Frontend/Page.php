<?php

namespace Features\Frontend;

use Features\Media\Banner;
use Features\Catalog\Product;
use Features\Catalog\Category;
use Katyusha\Framework\Eloquent\Model;
use Features\Catalog\CatalogCollection;
use Features\Shop\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Katyusha\Framework\Eloquent\ModelTraits\HasNamespace;

/**
 * @property string heading
 * @property string subheading
 * @property string background
 * @property int sort_order
 * @property Collection|CatalogCollection[] collections
 * @property Collection|Banner[] banners
 * @property Collection|Product[] products
 * @property Collection|Category[] categories
 */
class Page extends Model {
    use BelongsToShop;
    use HasNamespace;

    public $timestamps = false;
    public $sortable   = ['order_column_name' => 'sort_order', 'sort_when_creating' => true];

    protected $table = 'page.pages';
    protected $with  = ['products', 'collections', 'categories', 'banners'];

    public function toArray() {
        $base     = parent::toArray();
        $products = [];

        foreach ($this->products as $product) {
            $products[] = $product;
        }

        foreach ($this->categories as $cat) {
            foreach ($cat->products as $product) {
                $products[] = $product;
            }
        }

        $base['products'] = $products;

        return $base;
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany(Category::class, 'page.page_categories');
    }

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'page.page_products');
    }

    public function collections(): BelongsToMany {
        return $this->belongsToMany(CatalogCollection::class, 'page.page_collections');
    }

    public function banners(): BelongsToMany {
        return $this->belongsToMany(Banner::class, 'page.page_banners');
    }
}
