<?php

namespace Katyusha\Framework\Utils;

use function array_keys;
use function Dash\Curry\keys;
use function Dash\toArray;
use Katyusha\Utils\UnderscoreImplementation as __;
use function number_format;
use function round;

class _
{
    public static function guessType($input): string
    {
        return __::guessType($input);
    }

    public static function ifSetReturn(string $key, array $array, $default = null)
    {
        if (isset($array[$key])) {
            return $array[$key];
        }

        return $default;
    }

    public static function isInt($value): bool
    {
        return (int) $value === $value;
    }

    public static function isNull($input): bool
    {
        return __::isNull($input);
    }

    public static function ensureMin(int $value, int $min)
    {
        return $value >= $min ? $value : $min;
    }

    public static function ensureMax(int $value, int $max)
    {
        return $value <= $max ? $value : $max;
    }

    public static function divideEnsureMinimum(int $divide, int $by, int $minimum): int
    {
        return $divide / $by >= $minimum ? round($divide / $by) : $minimum;
    }

    public static function timesWihoutExceeding(int $times, int $by, int $maximum): int
    {
        return $times * $by <= $maximum ? round($times * $by) : $maximum;
    }

    public static function numberPrecision($number, $decimals = 0): float
    {
        return __::numberPrecision($number, $decimals);
    }

    public static function isFalse($input): bool
    {
        return __::isFalse($input);
    }

    public static function isTrue($input): bool
    {
        return __::isTrue($input);
    }

    public static function toBool($input, $allowYN = false): bool
    {
        return __::toBool($input, $allowYN);
    }

    public static function toString($input): string
    {
        return __::toString($input);
    }

    public static function toSingleLetter($input): ?string
    {
        return __::toSingleLetter($input);
    }

    public static function checkIfContainsEmptyValues(...$values)
    {
        return __::checkIfContainsEmptyValues($values);
    }

    public static function ensureStringIsOneOfInArray($input, array $within): ?string
    {
        return __::ensureStringIsOneOfInArray($input, $within);
    }

    public static function setArrayItemAsKeyOfAllItems(string $key, array $array): array
    {
        return __::setArrayItemAsKeyOfAllItems($key, $array);
    }

    public static function removeNonNumeric($input)
    {
        return __::removeNonNumeric($input);
    }

    public static function toInt($input, bool $strict = false): ?int
    {
        return __::toInt($input, $strict);
    }

    public static function toFloat($input, ?int $decimalPoints = null): float
    {
        return $decimalPoints ? number_format(__::toFloat($input), $decimalPoints) : __::toFloat($input);
    }

    public static function toFloatPrice($input): float
    {
        return __::toFloatPrice($input);
    }

    public static function getEnvFromString(string $key, string $string): string
    {
        return __::getEnvFromString($key, $string);
    }

    public static function ensureObjectOrClassContainsProperties($input, $properties): bool
    {
        return __::ensureObjectOrClassContainsProperties($input, $properties);
    }

    public static function isOfClassOrAnObject($input, $class): bool
    {
        return __::isOfClassOrAnObject($input, $class);
    }

    public static function extractArrayLevel(array $array)
    {
        return __::extractArrayLevel($array);
    }

    public static function multiDimensionalArrayToSingle(array $array, string $key, string $value)
    {
        return __::multiDimensionalArrayToSingle($array, $key, $value);
    }

    public static function createCombinationOfArrays(array $array): array
    {
        return __::createCombinationOfArrays($array);
    }

    public static function toArray($input): array
    {
        return toArray($input);
    }

    public static function toObject($input)
    {
        return json_decode(json_encode($input));
    }

    public static function keys($input): array
    {
        return keys($input);
    }

    public static function arrayUnique(array $input): array
    {
        $output = [];
        foreach ($input as $item) {
            if ($item) {
                $output[$item] = $item;
            }
        }

        return array_keys($output);
    }
}
