<?php

namespace Katyusha\Framework\Utils;

use ReflectionException;
use ReflectionObject;

class _Object
{
    public static function cast($sourceObject, string $destinationObject)
    {
        $destinationObject = new $destinationObject();

        try {
            $reflectedSource = new ReflectionObject($sourceObject);
            $reflectedDestination = new ReflectionObject($destinationObject);
            $sourceProperties = $reflectedSource->getProperties();
            foreach ($sourceProperties as $sourceProperty) {
                $sourceProperty->setAccessible(true);
                $name = $sourceProperty->getName();
                $value = $sourceProperty->getValue($sourceObject);

                if ($reflectedDestination->hasProperty($name)) {
                    $propDest = $reflectedDestination->getProperty($name);
                    $propDest->setAccessible(true);
                    $propDest->setValue($destinationObject, $value);
                } else {
                    $destinationObject->{$name} = $value;
                }
            }
        } catch (ReflectionException $exception) {
            return $sourceObject;
        }

        return $destinationObject;
    }
}
