<?php

namespace Katyusha\Framework\Eloquent\BaseModelTraits;

use Exception;
use Illuminate\Support\Str;

trait UuidHelperSaver
{
    public static function bootUuidHelperSaver(): void
    {
        static::saving(function ($model): void {
            if ($model->shop_id && ! Str::isUuid($model->shop_id)) {
                throw new Exception('SHop is not UUID');
            }
        });
    }
}
