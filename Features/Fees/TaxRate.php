<?php

namespace Features\Fees;

use App\Exceptions\ModelSavingException;
use Features\Catalog\Category;
use Features\Catalog\Product;
use Features\Shop\Traits\BelongsToShop;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Katyusha\Framework\Eloquent\Model;

/**
 * @property string name
 * @property int rate
 */
class TaxRate extends Model
{
    use BelongsToShop;

    protected $table = 'shop.tax_rates';

    public static function boot(): void
    {
        parent::boot();

        self::updating(function (self $model): void {
            throw new ModelSavingException('Tax rates cannot be updated');
        });
    }

    public function getValueWithoutTax(int $value): int
    {
        return $value / (1 + ($this->rate / 100));
    }

    public function getTaxAmountOfValue(int $value): int
    {
        return $value - $this->getValueWithoutTax($value);
    }

    // TODO
    public static function getProductTaxRate(Product $product): self
    {
        return self::query()->get()->first();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'shop.tax_rate_categories');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'shop.tax_rate_products');
    }
}
