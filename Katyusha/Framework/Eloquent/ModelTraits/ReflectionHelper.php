<?php

namespace Katyusha\Framework\Eloquent\ModelTraits;

use Illuminate\Support\Str;
use Katyusha\Framework\Eloquent\Support\Objects\ClassProperty;
use ReflectionClass;
use ReflectionProperty;

trait ReflectionHelper
{
    protected static array $directClassSkip = ['table', 'timestamps', 'created_at', 'updated_at', 'entityClass'];

    public static function reflection(): ReflectionClass | static
    {
        return new ReflectionClass(static::class);
    }

    public static function getParentClass(): ?string
    {
        return static::reflection()->getParentClass()->getName();
    }

    public static function skipFromDirectClassProperties(): array
    {
        return array_merge(self::$directClassSkip, static::$directClassSkip);
    }

    public static function hasProperty(string $name): bool
    {
        foreach (static::directClassProperties() as $property) {
            if ($property->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array|array<ClassProperty>
     */
    public static function directClassProperties(): array
    {
        $res = static::parseDocBlock();
        $cleaned = [];

        foreach (static::reflection()->getProperties() as $property) {
            if ($property->class === static::class) {
                $res[] = new ClassProperty($property->getName(), $property->getType() ?? 'unknown', static::isPropertyRequired($property));
            }
        }

        foreach ($res as $item) {
            if (! in_array($item->getName(), static::skipFromDirectClassProperties())) {
                $cleaned[] = $item;
            }
        }

        return $cleaned;
    }

    private static function isPropertyRequired(ReflectionProperty $property): bool
    {
        if ($property->hasDefaultValue()) {
            return false;
        }

        if ($property->getType() === 'bool') {
            return false;
        }

        return true;
    }

    /**
     * Parse the DocBlock of a class to get the properties.
     *
     * @return array<ClassProperty>
     */
    private static function parseDocBlock(): array
    {
        $docComment = static::reflection()->getDocComment();
        preg_match_all("#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#", $docComment, $matches, PREG_PATTERN_ORDER);
        $docBlock = $matches[0] ?? [];
        $properties = [];

        foreach ($docBlock as $line) {
            if (! Str::contains($line, 'property')) {
                continue;
            }

            $boom = explode(' ', $line);
            $name = end($boom);
            $type = explode('|', $boom[1])[0];
            $required = ! Str::contains($type, '?');
            $type = str_replace('?', '', $type);
            $properties[] = new ClassProperty($name, $type, $required);
        }

        return $properties;
    }
}
