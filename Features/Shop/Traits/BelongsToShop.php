<?php

namespace Features\Shop\Traits;

use Features\Shop\Shop;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Katyusha\Framework\Eloquent\Model;

/**
 * @mixin Model
 *
 * @property string shop_id
 * @property Shop shop
 */
trait BelongsToShop
{
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function getShopId(): string
    {
        return $this->shop_id;
    }

    public function setShopId(string $shop_id): BelongsToShop
    {
        $this->shop_id = $shop_id;

        return $this;
    }
    protected static function bootBelongsToShop(): void
    {
        static::creating(function ($model): void {
            if (! $model->shop_id) {
                $model->shop_id = me()->getShopId();
            }
        });
    }
}
