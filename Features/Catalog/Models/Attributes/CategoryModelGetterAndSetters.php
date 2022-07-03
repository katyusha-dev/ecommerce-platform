<?php

namespace Features\Catalog\Models\Attributes;

use Features\Catalog\Models\CategoryModel;

trait CategoryModelGetterAndSetters
{
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CategoryModel
    {
        $this->name = $name;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): CategoryModel
    {
        $this->active = $active;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): CategoryModel
    {
        $this->description = $description;

        return $this;
    }

    public function getTopDescription(): string
    {
        return $this->top_description;
    }

    public function setTopDescription(string $top_description): CategoryModel
    {
        $this->top_description = $top_description;

        return $this;
    }

    public function getBottomText(): string
    {
        return $this->bottom_text;
    }

    public function setBottomText(string $bottom_text): CategoryModel
    {
        $this->bottom_text = $bottom_text;

        return $this;
    }

    public function getParentId(): string
    {
        return $this->parent_id;
    }

    public function setParentId(string $parent_id): CategoryModel
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    public function getImportedParentId(): string
    {
        return $this->imported_parent_id;
    }

    public function setImportedParentId(string $imported_parent_id): CategoryModel
    {
        $this->imported_parent_id = $imported_parent_id;

        return $this;
    }

    public function getImportedId(): int
    {
        return $this->imported_id;
    }

    public function setImportedId(int $imported_id): CategoryModel
    {
        $this->imported_id = $imported_id;

        return $this;
    }

    public function getSortOrder(): int
    {
        return $this->sort_order;
    }

    public function setSortOrder(int $sort_order): CategoryModel
    {
        $this->sort_order = $sort_order;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): CategoryModel
    {
        $this->image = $image;

        return $this;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): CategoryModel
    {
        $this->icon = $icon;

        return $this;
    }
}
