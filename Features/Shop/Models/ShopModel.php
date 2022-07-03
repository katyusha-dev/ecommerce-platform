<?php

namespace Features\Shop\Models;

use Features\Catalog\Tag;
use Features\Media\Video;
use Features\Fees\TaxRate;
use Features\Client\Client;
use Features\Frontend\Page;
use Features\Catalog\Product;
use Features\Purchasing\Cart;
use Features\Shop\ShopApiKey;
use Features\Catalog\Category;
use Features\Purchasing\Order;
use Features\Purchasing\Refund;
use Features\Purchasing\Payment;
use Features\Catalog\CatalogMedia;
use Katyusha\Framework\Eloquent\Model;
use Features\Catalog\CatalogCollection;
use Katyusha\Framework\Eloquent\Builder;
use Katyusha\Framework\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Katyusha\Framework\Eloquent\ModelTraits\HasNamespace;
use Features\Shop\Models\SettersAndGetters\ShopSettersAndGetters;

/**
 * @property string name
 * @property string namespace
 * @property string domain
 * @property string logo
 * @property string banner
 * @property string email
 * @property string address
 * @property string city
 * @property string video
 * @property string video_bg
 * @property int zip
 * @property string wc_consumer_key
 * @property string wc_consumer_secret
 * @property string wc_url
 * @property string customer_id
 * @property Client client
 * @property Collection|Product[] products
 * @property Collection|Category[] categories
 * @property Collection|CatalogCollection[] collections
 * @property Collection|Tag[] tags
 * @property Collection|Cart[] carts
 * @property Collection|Order[] orders
 * @property Collection|ShippingMethod[] shippingMethods
 * @property ShopApiKey apiKeys
 * @property Collection|Payment[] payments
 * @property Collection|Refund[] refunds
 * @property Collection|TaxRate[] taxRates
 * @property Collection|Page[] pages
 * @property Collection|Banner[] banners
 * @property Collection|Video[] videos
 */
class ShopModel extends Model {
    use HasNamespace;
    use ShopSettersAndGetters;

    protected $table = 'shop.shops';

    public function newCollection(array $models = []): Collection {
        return new Collection($models);
    }

    public function newEloquentBuilder($query): Builder {
        return new Builder($query);
    }

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }

    public function video(): BelongsTo {
        return $this->belongsTo(Video::class);
    }

    public function pages(): HasMany {
        return $this->hasMany(Page::class);
    }

    public function banners(): HasMany {
        return $this->hasMany(Banner::class);
    }

    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany {
        return $this->hasMany(Category::class);
    }

    public function collections(): HasMany {
        return $this->hasMany(CatalogCollection::class);
    }

    public function tags(): HasMany {
        return $this->hasMany(Tag::class);
    }

    public function catalogMedia(): HasMany {
        return $this->hasMany(CatalogMedia::class);
    }

    public function orders(): HasMany {
        return $this->hasMany(Order::class);
    }

    public function carts(): HasMany {
        return $this->hasMany(Cart::class);
    }

    public function shippingMethods(): HasMany {
        return $this->hasMany(ShippingMethod::class);
    }

    public function apiKeys(): HasOne {
        return $this->hasOne(ShopApiKey::class);
    }

    public function payments(): HasMany {
        return $this->hasMany(Payment::class);
    }

    public function refunds(): HasMany {
        return $this->hasMany(Refund::class);
    }

    public function taxRates(): HasMany {
        return $this->hasMany(TaxRate::class);
    }
}
