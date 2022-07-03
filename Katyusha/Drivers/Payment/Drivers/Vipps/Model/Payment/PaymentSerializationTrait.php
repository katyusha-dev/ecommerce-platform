<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;

trait PaymentSerializationTrait
{
    public static function getSerializer()
    {
        return SerializerBuilder::create()
            ->setPropertyNamingStrategy(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()))
            ->build();
    }
}
