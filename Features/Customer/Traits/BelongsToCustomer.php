<?php

namespace Features\Customer\Traits;

use Features\Customer\Customer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Katyusha\Framework\Eloquent\Model;

/**
 * @mixin Model
 *
 * @property string customer_id
 * @property Customer customer
 */
trait BelongsToCustomer
{
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getCustomerId(): ?string
    {
        return $this->customer_id;
    }

    public function setCustomerId(?string $customer_id): static
    {
        if ($customer_id) {
            $this->customer_id = $customer_id;
        }

        return $this;
    }
}
