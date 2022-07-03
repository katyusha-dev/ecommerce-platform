<?php

namespace Features\Catalog\Eloquent\SettersAndGetters;

use Carbon\Carbon;
use Features\Catalog\Models\ProductModel;

/**
 * @mixin ProductModel
 */
trait ProductModelSettersAndGetters
{
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ProductModel
    {
        $this->name = $name;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): ProductModel
    {
        $this->active = $active;

        return $this;
    }

    public function getCostPrice(): ?float
    {
        return $this->cost_price;
    }

    public function setCostPrice(?float $cost_price): ProductModel
    {
        $this->cost_price = $cost_price;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): ProductModel
    {
        $this->price = $price;

        return $this;
    }

    public function getSalePrice(): ?float
    {
        return $this->sale_price;
    }

    public function setSalePrice(?float $sale_price): ProductModel
    {
        $this->sale_price = $sale_price;

        return $this;
    }

    public function getSaleDateFrom(): ?Carbon
    {
        return $this->sale_date_from;
    }

    public function setSaleDateFrom(?Carbon $sale_date_from): ProductModel
    {
        $this->sale_date_from = $sale_date_from;

        return $this;
    }

    public function getSaleDateTo(): ?Carbon
    {
        return $this->sale_date_to;
    }

    public function setSaleDateTo(?Carbon $sale_date_to): ProductModel
    {
        $this->sale_date_to = $sale_date_to;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): ProductModel
    {
        $this->sku = $sku;

        return $this;
    }

    public function getImageId(): ?string
    {
        return $this->image_id;
    }

    public function setImageId(?string $image_id): ProductModel
    {
        $this->image_id = $image_id;

        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->sort_order;
    }

    public function setSortOrder(?int $sort_order): ProductModel
    {
        $this->sort_order = $sort_order;

        return $this;
    }

    public function isFeatured(): bool
    {
        return $this->featured;
    }

    public function setFeatured(bool $featured): ProductModel
    {
        $this->featured = $featured;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): ProductModel
    {
        $this->image = $image;

        return $this;
    }

    public function getGallery(): string
    {
        return $this->gallery;
    }

    public function setGallery(string $gallery): ProductModel
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): ProductModel
    {
        $this->description = $description;

        return $this;
    }

    public function getProductGridDescription(): ?string
    {
        return $this->product_grid_description;
    }

    public function setProductGridDescription(?string $product_grid_description): ProductModel
    {
        $this->product_grid_description = $product_grid_description;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): ProductModel
    {
        $this->stock = $stock;

        return $this;
    }

    public function getExternalId(): ?int
    {
        return $this->external_id;
    }

    public function setExternalId(?int $external_id): ProductModel
    {
        $this->external_id = $external_id;

        return $this;
    }

    public function isManageStock(): bool
    {
        return $this->manage_stock;
    }

    public function setManageStock(bool $manage_stock): ProductModel
    {
        $this->manage_stock = $manage_stock;

        return $this;
    }

    public function isHideWhenOutOfStock(): bool
    {
        return $this->hide_when_out_of_stock;
    }

    public function setHideWhenOutOfStock(bool $hide_when_out_of_stock): ProductModel
    {
        $this->hide_when_out_of_stock = $hide_when_out_of_stock;

        return $this;
    }
}
