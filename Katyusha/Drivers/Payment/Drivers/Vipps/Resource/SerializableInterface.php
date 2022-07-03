<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource;

use JMS\Serializer\Serializer;

/**
 * Class ResourceBase.
 */
interface SerializableInterface
{
    /**
     * Gets serializer value.
     */
    public function getSerializer(): Serializer;
}
