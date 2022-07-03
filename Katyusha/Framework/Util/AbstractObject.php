<?php

namespace Katyusha\Framework\Utils;

use function is_array;
use function is_numeric;
use function is_object;
use function is_string;
use stdClass;
use function trim;

/**
 * Class AbstractObject.
 *
 * @param
 */
class AbstractObject
{
    public static function getDocType($input): string
    {
        $type = 'string';

        if (is_array($input)) {
            $type = 'array';
        }

        if (is_object($input)) {
            $type = 'stdClass';
        }

        if (is_numeric($input)) {
            $type = 'int';

            if (mb_strpos($input, '.')) {
                $type = 'float';
            }
        }

        return $type;
    }

    public static function buildPHPDocParams($input): string
    {
        $response = '';
        foreach ($input as $k => $v) {
            $type = self::getDocType($v);
            $response .= " * @param {$type} {$k}<br/>";
        }

        return $response;
    }

    public static function createAndAutoAssign($input): self
    {
        $object = new static();
        $object->autoAssign($input);

        return $object;
    }

    public static function collectionFromArray(array $items): array
    {
        $res = [];
        foreach ($items as $item) {
            if ($item) {
                $res[] = static::createAndAutoAssign($item);
            }
        }

        return $res;
    }

    /**
     * @throws
     */
    public function autoAssign(array|stdClass $input): void
    {
        foreach ($input as $k => $v) {
            $this->{$k} = is_string($v) ? trim($v) : $v;
        }

        new PHPDoc(static::class, $this);
    }
}
