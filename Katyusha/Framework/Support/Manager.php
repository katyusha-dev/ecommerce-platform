<?php

namespace Katyusha\Framework\Support;

use Illuminate\Support\Manager as LaravelManager;

abstract class Manager extends LaravelManager
{
    public static function create(mixed $driver, ...$args): static
    {
        $driver = static::driver($driver);
        $driver->setup(...$args);

        return $driver;
    }
}
