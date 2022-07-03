<?php

namespace Katyusha\Framework;

class Request
{
    public static function getRequestHostname(): string
    {
        return request()->header('Origin');
    }
}
