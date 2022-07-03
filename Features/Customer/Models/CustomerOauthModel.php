<?php

namespace Features\Customer\Models;

use Features\Customer\Customer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Katyusha\Framework\Eloquent\Model;

class CustomerOauthModel extends Model
{
    protected $table = 'customer.oauth';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
