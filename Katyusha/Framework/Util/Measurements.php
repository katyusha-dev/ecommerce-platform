<?php

namespace Katyusha\Framework\Utils;

use function explode;
use function is_numeric;
use ReflectionClass;
use function str_replace;
use System\_;
use System\_Array;
use System\Objects\Measurement\MeasurementObject;

class Measurements
{
    public const KG = 'kg';
    public const G = 'g';
    public const ML = 'ml';
    public const L = 'l';
    public const M = 'm';
    public const CM = 'cm';
    public const DM = 'dm';
    public const DL = 'dl';

    public static function attemptToParseMeasurementFromString(string $input): ?MeasurementObject
    {
        $reflection = new ReflectionClass(self::class);
        $items = _Array::performFunctions(explode(' ', $input), 'trim', 'strtolower');

        $unit = null;
        $value = null;

        foreach ($reflection->getConstants() as $constant) {
            foreach ($items as $item) {
                if ($numeric = _::removeNonNumeric(str_replace($constant, '', $item))) {
                    if (! is_numeric($numeric) || $numeric.$constant !== $item) {
                        continue;
                    }

                    $unit = $constant;
                    $value = _::toInt($numeric);
                }
            }
        }

        if ($unit && $value) {
            return new MeasurementObject($value, $unit);
        }

        return null;
    }
}
