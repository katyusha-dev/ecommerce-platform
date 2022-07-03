<?php

namespace Katyusha\Framework\Eloquent\Support\Objects;

class ClassProperty
{
    public function __construct(protected string $name, protected string $type, protected bool $required)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }
}
