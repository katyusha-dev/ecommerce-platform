<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model;

use JMS\Serializer\SerializerInterface;

interface FromStringInterface
{
    public static function fromString(string $string, ?SerializerInterface $serializer = null): static;
}
