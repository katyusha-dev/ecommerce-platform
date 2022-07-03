<?php

namespace Features\Purchasing\Models;

use Features\Customer\CustomerSession;
use Features\Customer\Traits\BelongsToCustomer;
use Features\Purchasing\LineItem;
use Features\Purchasing\Models\SettersAndGetters\CartSettersAndGetters;
use Features\Purchasing\Order;
use Features\Shop\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Katyusha\Framework\Eloquent\Builder;
use Katyusha\Framework\Eloquent\Collection;
use Katyusha\Framework\Eloquent\Model;

/**
 * @property ?string session_id
 * @property ?string order_id
 * @property ?string customer_id
 * @property ?Carbon attempted_checkout_at
 * @property ?Order order
 */
class CartModel extends Model
{
    use BelongsToShop;
    use BelongsToCustomer;
    use CartSettersAndGetters;

    protected $dates = ['attempted_checkout_at'];
    protected $table = 'purchasing.carts';

    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(CustomerSession::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function lineItems(): HasMany
    {
        return $this->hasMany(LineItem::class);
    }
}
