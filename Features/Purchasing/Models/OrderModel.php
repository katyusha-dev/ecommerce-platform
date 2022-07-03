<?php

namespace Features\Purchasing\Models;

use Carbon\Carbon;
use Features\Customer\CustomerSession;
use Features\Customer\Traits\BelongsToCustomer;
use Features\Purchasing\Cart;
use Features\Purchasing\LineItem;
use Features\Purchasing\Models\SettersAndGetters\OrderSettersAndGetters;
use Features\Purchasing\Payment;
use Features\Shop\Shop;
use Features\Shop\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Katyusha\Framework\Eloquent\Builder;
use Katyusha\Framework\Eloquent\Collection;
use Katyusha\Framework\Eloquent\Model;

/**
 * @property ?string session_id
 * @property string cart_id
 * @property ?string payment_method
 * @property bool paid
 * @property Payment[] payments
 * @property Payment successfulPayment
 * @property Payment activePayment
 */
class OrderModel extends Model
{
    use BelongsToShop;
    use BelongsToCustomer;
    use OrderSettersAndGetters;

    protected $table = 'purchasing.orders';

    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(CustomerSession::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function lineItems(): HasMany
    {
        return $this->hasMany(LineItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function activePayment(): HasOne
    {
        return $this->hasOne(Payment::class)
            ->where('valid_until', '<=', Carbon::now())
            ->where('approved', false)
            ->where('cancelled', false)
            ->where('declined', false)
            ->where('complete', false);
    }

    public function successfulPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->where('complete', true);
    }
}
