<?php

namespace Katyusha\Framework\Traits;

trait Makeable
{
    public static function make(): self
    {
        return new self();
    }
}
