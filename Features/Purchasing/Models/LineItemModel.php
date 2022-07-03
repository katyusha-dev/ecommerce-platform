<?php

namespace Features\Purchasing\Models;

use Features\Fees\TaxRate;
use Features\Catalog\Product;
use Features\Purchasing\Cart;
use Katyusha\Framework\Money;
use Features\Catalog\Category;
use Features\Purchasing\Order;
use Katyusha\Framework\Eloquent\Model;
use Features\Shop\Traits\BelongsToShop;
use Katyusha\Framework\Eloquent\Builder;
use Features\Catalog\Variables\Variation;
use Katyusha\Framework\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Features\Purchasing\Models\SettersAndGetters\LineItemSettersAndGetters;

/**
 * @property ?string order_id
 * @property string product_id
 * @property ?string variation_id
 * @property string cart_id
 * @property string tax_rate_id
 * @property Money individual_item_price
 * @property int qty
 * @property Cart cart
 * @property Order order
 * @property TaxRate taxRate
 */
class LineItemModel extends Model {
    use BelongsToShop;
    use LineItemSettersAndGetters;

    protected $table = 'purchasing.line_items';
    protected $casts = ['individual_item_price' => Money::class];

    public function newCollection(array $models = []): Collection {
        return new Collection($models);
    }

    public function newEloquentBuilder($query): Builder {
        return new Builder($query);
    }

    public function cart(): BelongsTo {
        return $this->belongsTo(Cart::class);
    }

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }

    public function taxRate(): BelongsTo {
        return $this->belongsTo(TaxRate::class);
    }

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function variation(): BelongsTo {
        return $this->belongsTo(Variation::class);
    }
}
