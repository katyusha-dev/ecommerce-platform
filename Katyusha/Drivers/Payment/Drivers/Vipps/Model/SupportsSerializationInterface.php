<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model;

use JMS\Serializer\SerializerInterface;

interface SupportsSerializationInterface
{
    /**
     * @return SerializerInterface $serializer
     */
    public static function getSerializer(): SerializerInterface;
}
