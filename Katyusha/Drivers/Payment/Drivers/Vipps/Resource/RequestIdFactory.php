<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource;

use function Drivers\Clients\Payments\Vipps\Resource\uniqid;

/**
 * Class RequestIdFactory.
 */
abstract class RequestIdFactory
{
    /**
     * Generates unique 23 character long ID.
     */
    public static function generate(): string
    {
        return uniqid('', true);
    }
}
