<?php

namespace Katyusha\Framework\Eloquent\Contracts;

use Katyusha\Framework\Eloquent\Model;

interface CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     */
    public function get(Model $model, string $key, $value, array $attributes): mixed;

    /**
     * Transform the attribute to its underlying model values.
     */
    public function set(Model $model, string $key, $value, array $attributes): mixed;
}
