<?php

namespace Katyusha\Framework\Eloquent\ModelTraits;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use Katyusha\Framework\Eloquent\Model;

/**
 * @mixin Model
 * @property string namespace
 */
trait Hasnamespace
{
    protected static function bootHasNamespace(): void
    {
        static::creating(function ($model): void {
            $model->namespace = Str::slug(mb_strtolower($model->name));

            if (static::whereNamespace($model->namespace)->first()) {
                $model->namespace .= '-'.Str::random(8);
            }
        });
    }
}
