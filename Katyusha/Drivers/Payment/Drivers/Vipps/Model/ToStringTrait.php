<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model;

use Doctrine\Common\Annotations\AnnotationRegistry;
use function Drivers\Clients\Payments\Vipps\Model\sprintf;
use InvalidArgumentException;
use JMS\Serializer\SerializerInterface;

trait ToStringTrait
{
    /** @noinspection PhpDeprecationInspection */
    public function toString()
    {
        if (! isset($this->serializer) && ($this instanceof SupportsSerializationInterface)) {
            AnnotationRegistry::registerLoader('class_exists');
            $serializer = static::getSerializer();
        } elseif (! isset($this->serializer)) {
            throw new InvalidArgumentException(sprintf('Missing %s', SerializerInterface::class));
        } else {
            $serializer = $this->serializer;
        }

        return $serializer->serialize(
            $this,
            'json'
        );
    }
}
