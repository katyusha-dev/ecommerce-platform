<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model;

use Doctrine\Common\Annotations\AnnotationRegistry;
use function Drivers\Clients\Payments\Vipps\Model\in_array;
use function Drivers\Clients\Payments\Vipps\Model\sprintf;
use InvalidArgumentException;
use JMS\Serializer\SerializerInterface;

trait FromStringTrait
{
    /** @noinspection PhpDeprecationInspection */
    public static function fromString($string, ?SerializerInterface $serializer = null)
    {
        if (! isset($serializer) && in_array(SupportsSerializationInterface::class, class_implements(static::class))) {
            AnnotationRegistry::registerLoader('class_exists');
            $serializer = static::getSerializer();
        } elseif (! isset($serializer)) {
            throw new InvalidArgumentException(sprintf('Missing %s', SerializerInterface::class));
        }

        return $serializer->deserialize(
            $string,
            static::class,
            'json'
        );
    }
}
