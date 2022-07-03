<?php

namespace Katyusha\Framework\Eloquent;

use App\Data\Eloquent\AppModel;
use Illuminate\Eloquent\Relations\Concerns\AsPivot;

abstract class PivotModel extends AppModel
{
    use AsPivot;
    public $timestamps = false;

    public function hasTimestampAttributes()
    {
        return false;
    }
}
