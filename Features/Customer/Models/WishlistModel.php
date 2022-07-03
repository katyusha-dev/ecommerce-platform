<?php

namespace Features\Customer\Models;

use Features\Catalog\Product;
use Features\Customer\Customer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Katyusha\Framework\Eloquent\Model;

class WishlistModel extends Model
{
    protected $table = 'customer.wishlists';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
