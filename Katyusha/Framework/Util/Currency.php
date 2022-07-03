<?php

namespace Katyusha\Framework\Utils;

use function floatval;
use function number_format;

class Currency
{
    public static function parse($amount = 0, string $currency = 'kr'): string
    {
        return number_format(floatval($amount), 0, ',', '.').$currency;
    }
}
