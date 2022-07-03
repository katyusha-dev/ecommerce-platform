<?php

namespace Katyusha\Framework\Utils;

class Temp
{
    public static function getTempPath(string $fileName): string
    {
        return '/srv/tmp/'.$fileName;
    }
}
