<?php

namespace Katyusha\Framework\Utils;

use function explode;
use function is_array;
use function is_object;
use stdClass;
use function trim;

class _Array
{
    public static function parseCsvToArray(string $contents, string $delimeter): array
    {
        $response = [];
        foreach (explode("\n", $contents) as $row) {
            $response[] = explode($delimeter, $row);
        }

        return $response;
    }

    public static function extractKeys(array $input, array $keys): array
    {
        $res = [];
        foreach ($input as $item) {
            $row = new stdClass();
            foreach ($keys as $k) {
                if (is_array($item)) {
                    $row->{$k} = $item[$k];
                } else {
                    $row->{$k} = $item->{$k};
                }
            }

            $res[] = $row;
        }

        return $res;
    }

    public static function buildFromMultipleSringsAsKeys(string $key, $arrOrObj): array
    {
        $res = [];

        if (! is_array($arrOrObj)) {
            return [];
        }

        foreach ($arrOrObj as $k => $value) {
            if (mb_strpos($k, $key) > -1) {
                $res[] = $value;
            }
        }

        return $res;
    }

    public static function extractKeyValue($arr, $key)
    {
        $res = [];

        foreach ($arr as $k => $v) {
            if (\is_array($v)) {
                $v = self::toObject($v);
            }
            $res[] = $v->{$key};
        }

        return $res;
    }

    public static function extractOneLevelDeep(array $input, $assosciative = true): array
    {
        $res = [];
        foreach ($input as $item) {
            foreach ($item as $k => $v) {
                if ($assosciative) {
                    $res[$k] = $v;
                } else {
                    $res[] = $v;
                }
            }
        }

        return $res;
    }

    public static function removeEmpty(array $input): array
    {
        $res = [];
        foreach ($input as $item) {
            if ($item && mb_strlen(trim($item))) {
                $res[] = $item;
            }
        }

        return $res;
    }

    public static function renameKeys(array $keyRelationship, $array): array
    {
        $res = [];
        foreach ($array as $row) {
            $newRow = [];
            foreach ($row as $k => $v) {
                if (! isset($keyRelationship[$k])) {
                    continue;
                }
                $relMatch = $keyRelationship[$k];
                $newRow[$relMatch] = $v;
            }

            $res[] = $newRow;
        }

        return $res;
    }

    public static function performFunctions(array $input, ...$functions): array
    {
        $res = [];
        foreach ($input as $item) {
            foreach ($functions as $func) {
                $item = $func($item);
            }

            $res[] = $item;
        }

        return $res;
    }

    public static function trim(array $input): array
    {
        $res = [];
        foreach ($input as $item) {
            $res[] = trim($item);
        }

        return $res;
    }

    public static function getObjectOfArrayByAKeysValue(array $input, string $key, string $keyValue, ?string $returnKey = null)
    {
        foreach ($input as $item) {
            if ($item->{$key} === $keyValue) {
                return $returnKey ? $item->{$returnKey} : $item;
            }
        }

        return null;
    }

    public static function getLowestNumber(array $input): int
    {
        $lowest = 1000000;
        foreach ($input as $item) {
            if (_::toInt($item) < $lowest) {
                $lowest = _::toInt($item);
            }
        }

        return $lowest;
    }

    public static function typecastValues(array $input, string $typecast): array
    {
        $res = [];
        foreach ($input as $item) {
            if ($typecast === 'int') {
                $item = _::toInt($item);
            }

            if ($typecast === 'float') {
                $item = _::toFloat($item);
            }
            $res[] = $item;
        }

        return $res;
    }

    public static function returnWithoutValue(array $input, string $exclude): array
    {
        $res = [];
        foreach ($input as $v) {
            if ($v !== $exclude) {
                $res[] = $v;
            }
        }

        return $res;
    }

    public static function extractIntoSingleDimensionalKeyVal(array $array, string $keyName, string $valueName): array
    {
        $res = [];
        foreach ($array as $item) {
            $res[$item->{$keyName}] = $item->{$valueName};
        }

        return $res;
    }

    public static function multiDimentionalToSingleRelative(array $input, string $k, string $v): array
    {
        $res = [];
        foreach ($input as $item) {
            if (is_object($item)) {
                $res[$item->{$k}] = $item->{$v};
            } elseif (is_array($item)) {
                $res[$item[$k]] = $item[$v];
            }
        }

        return $res;
    }

    public static function singleDimensionalToMulti(array $input): array
    {
        $res = [];
        foreach ($input as $item) {
            $res[$item] = $item;
        }

        return $res;
    }

    public static function numericRange(int $start, int $end): array
    {
        $res = [];
        $x = $start;
        while ($x <= $end) {
            $res[] = $x;
            $x++;
        }

        return $res;
    }

    public static function iterateAndFlatten($arr, $key = false, $numericalize = false)
    {
        $obj = \is_object($arr);
        $arr = \json_decode(\json_encode($arr), true);

        foreach ($arr as $k => $v) {
            $vals = \array_values($v[$key]);

            if ($numericalize) {
                $vals = self::numericalizeValues($vals);
            }
            $arr[$k][$key] = $vals;
        }

        return $obj ? (object) \json_decode(\json_encode($arr)) : (array) $arr;
    }

    public static function jsonDecodeKey($arr, $key)
    {
        $res = [];

        foreach ($arr as $item) {
            $item = (object) $item;
            $item->{$key} = \json_decode($item->{$key});
            $res[] = $item;
        }

        return $res;
    }

    public static function keyMath($arr, $key, $operation = '+')
    {
        $res = 0;

        foreach ($arr as $item) {
            $item = (object) $item;
            $val = $item->{$key};

            if ($operation === '+') {
                $res += $val;
            }
        }

        return $res;
    }

    public static function numericalizeValues($arr)
    {
        foreach ($arr as $key => $v) {
            if (-1 < \mb_strpos($arr[$key], '.')) {
                $arr[$key] = (float) ($arr[$key]);
            } else {
                $arr[$key] = (int) ($arr[$key]);
            }
        }

        return $arr;
    }

    public static function returnWithKeyAsArrKey($arr, $key)
    {
        $res = [];

        foreach ($arr as $k => $v) {
            if (\is_array($v)) {
                $v = self::toObject($v);
            }
            $res[$v->{$key}] = $v;
        }

        return $res;
    }

    public static function toArray($obj)
    {
        return (array) \json_decode(\json_encode($obj), true);
    }

    public static function toObject($arr)
    {
        return (object) \json_decode(\json_encode($arr));
    }
}
