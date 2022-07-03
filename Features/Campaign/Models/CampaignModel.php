<?php

namespace Features\Campaign\Models;

use Features\Shop\Traits\BelongsToShop;
use Katyusha\Framework\Eloquent\Model;

class CampaignModel extends Model
{
    use BelongsToShop;
}
