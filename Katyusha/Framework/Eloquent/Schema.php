<?php

namespace Katyusha\Framework\Eloquent;

use SchemaFieldTypes;

class Schema
{
    protected $fields = [];

    public function __construct(protected string $tableName)
    {
    }

    public static function make(string $tableName): self
    {
        return new self($tableName);
    }

    public function uuid(string $field): self
    {
        $this->fields[$field] = SchemaFieldTypes::UUID;

        return $this;
    }

    public function string(string $field): self
    {
        $this->fields[$field] = SchemaFieldTypes::STRING;

        return $this;
    }

    public function integer(string $field): self
    {
        $this->fields[$field] = SchemaFieldTypes::INT;

        return $this;
    }

    public function bigInteger(string $field): self
    {
        return $this->integer($field);
    }

    public function float(string $field): self
    {
        $this->fields[$field] = SchemaFieldTypes::FLOAT;

        return $this;
    }

    public function dateTime(string $field): self
    {
        $this->fields[$field] = SchemaFieldTypes::DATETIME;

        return $this;
    }

    public function boolean(string $field): self
    {
        $this->fields[$field] = SchemaFieldTypes::BOOLEAN;

        return $this;
    }
}
