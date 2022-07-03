<?php

namespace Katyusha\Framework\Eloquent\ModelTraits;

use Illuminate\Support\Facades\Gate;
use Katyusha\Framework\Eloquent\Model;

/**
 * @mixin Model
 */
trait HasPolicy
{
    protected static function bootHasPolicy(): void
    {
        if (mb_strlen(static::policy())) {
            Gate::policy(static::class, static::policy());
        }
    }
}
