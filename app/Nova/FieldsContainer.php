<?php

namespace App\Nova;

/**
 * This class will contain the fields for Nova.
 */
final class FieldsContainer {
    protected array $fields = [];

    public static function make(): self {
        return new self();
    }

    public function add(mixed $fields): self {
        if ($fields instanceof Fields) {
            $this->fields = array_merge($this->fields, $fields->toArray());
        } elseif (is_array($fields)) {
            $this->fields = array_merge($this->fields, $fields);
        } else {
            $this->fields[] = $fields;
        }

        return $this;
    }

    public function toArray(): array {
        return $this->fields;
    }
}
