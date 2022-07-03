<?php

namespace Katyusha\Framework\Eloquent\ModelTraits;

use Katyusha\framework\Eloquent\Model;

/**
 * @mixin Model
 */
trait NoPolicyOverride
{
    protected static function policy(): string
    {
        return '';
    }
}
