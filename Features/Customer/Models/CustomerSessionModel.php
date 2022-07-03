<?php

namespace Features\Customer\Models;

use Features\Customer\Customer;
use Katyusha\Framework\Eloquent\Model;
use Features\Customer\Traits\BelongsToCustomer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string key
 */
class CustomerSessionModel extends Model {
    use BelongsToCustomer;

    protected $table   = 'customer.sessions';
    protected $with    = ['customer'];
    protected $visible = ['customer'];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function getKey(): string {
        return $this->key;
    }

    public function setKey(string $key): static {
        return $this->set('key', $key);
    }
}
