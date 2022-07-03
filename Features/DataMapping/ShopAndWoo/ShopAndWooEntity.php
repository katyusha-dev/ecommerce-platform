<?php

namespace Features\DataMapping\ShopAndWoo;

use function is_numeric;
use function is_string;

abstract class ShopAndWooEntity
{
    protected $values = [];
    protected bool $forceIntVals = false;

    protected function set(string $key, mixed $value): static
    {
        if ($this->forceIntVals && is_numeric($value)) {
            $value = number_format($value, 0, '', '');
        }

        if (is_string($value)) {
            $value = trim($value);
        }

        $this->values[$key] = $value;

        return $this;
    }
}
