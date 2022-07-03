<?php

namespace Features\Client;

use Features\Shop\Shop;
use Katyusha\Framework\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Katyusha\Framework\Eloquent\ModelTraits\HasNamespace;

/**
 * @property string name
 * @property string namespace
 * @property string contact_email
 * @property bool active_customer
 */
class Client extends Model {
    use HasNamespace;

    protected $table = 'client.clients';

    public function shops(): HasMany {
        return $this->hasMany(Shop::class);
    }
}
