<?php

namespace Features\Client;

use Katyusha\Framework\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string client_id
 * @property string first_name
 * @property string last_name
 * @property int mobile
 * @property string position
 * @property bool is_decision_maker
 */
class Contacts extends Model {
    protected $table = 'client.contacts';

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }
}
