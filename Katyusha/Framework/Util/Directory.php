<?php

namespace Katyusha\Framework\Utils;

class Directory
{
    public static function scan(string $path, bool $fullPath = false): array
    {
        $res = [];

        if (! is_dir($path)) {
            return [];
        }
        foreach (scandir($path) as $item) {
            if (! in_array($item, ['.', '..'])) {
                $res[] = ($fullPath ? rtrim($path, '/').'/' : '').$item;
            }
        }

        return $res;
    }
}
