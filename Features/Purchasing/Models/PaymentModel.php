<?php

namespace Features\Purchasing\Models;

use Carbon\Carbon;
use Features\Customer\Customer;
use Features\Purchasing\Enums\PaymentProvidersEnum;
use Features\Purchasing\Models\SettersAndGetters\PaymentSettersAndGetters;
use Features\Purchasing\Order;
use Features\Shop\Shop;
use Features\Shop\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Katyusha\Framework\Eloquent\Builder;
use Katyusha\Framework\Eloquent\Collection;
use Katyusha\Framework\Eloquent\Model;
use Katyusha\Framework\Money;

/**
 * @property string order_id
 * @property Money amount
 * @property PaymentProvidersEnum payment_method
 * @property bool approved
 * @property bool cancelled
 * @property bool declined
 * @property string currency
 * @property ?Money amount_paid
 * @property ?Money amount_captured
 * @property Money total_without_tax
 * @property Money tax
 * @property bool complete
 * @property int numeric_id
 * @property Carbon valid_until
 * @property ?Carbon attempted_payment_at
 * @property ?Carbon completed_payment_at
 * @property Order order
 * @property Customer customer
 * @property Shop shop
 */
class PaymentModel extends Model
{
    use BelongsToShop;
    use PaymentSettersAndGetters;
    public const PAYMENT_MINUTES_EXPIRY = 15;

    protected $table = 'purchasing.payments';
    protected $dates = ['completed_payment_at', 'attempted_payment_at', 'valid_until'];
    protected $casts = [
        'amount' => Money::class,
        'amount_paid' => Money::class,
        'amount_captured' => Money::class,
        'total_without_tax' => Money::class,
        'tax' => Money::class,
        'payment_method' => PaymentProvidersEnum::class,
    ];

    public static function boot(): void
    {
        parent::boot();

        static::saving(function (self $model): void {
            $model->valid_until = Carbon::now()->addMinutes(self::PAYMENT_MINUTES_EXPIRY);
            $model->numeric_id = time().mt_rand(10000, 90000);
        });
    }

    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function customer(): HasOneThrough
    {
        return $this->hasOneThrough(Customer::class, Order::class, 'id', 'id', 'order_id', 'customer_id');
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
