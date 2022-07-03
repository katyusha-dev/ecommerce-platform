<?php

namespace Features\Customer\Models;

use Features\Catalog\Product;
use Katyusha\Framework\Eloquent\Model;
use Katyusha\Framework\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Features\Customer\Eloquent\SettersAndGetters\CustomerModelSetterAndGetters;

/**
 * @property ?string address
 * @property ?string address_2
 * @property ?string zip
 * @property ?string city
 * @property ?string country
 * @property ?string first_registration_shop
 * @property ?string email
 * @property ?string gender
 * @property ?string name_first
 * @property ?string name_last
 * @property int mobile_number
 * @property ?int password
 * @property Collection|Product[] favorites
 */
class CustomerModel extends Model {
    use CustomerModelSetterAndGetters;

    protected $table    = 'customer.customers';
    protected $fillable = ['address', 'address_2', 'zip', 'city', 'email', 'birthdate', 'name_first', 'name_last'];
    protected $visible  = ['mobile_number', 'address', 'address_2', 'zip', 'city', 'country', 'email', 'birthdate', 'name_first', 'name_last'];

    public function favorites(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'customer.favorites');
    }
}
