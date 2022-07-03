<?php

namespace Features\Purchasing\Models\SettersAndGetters;

use Features\Purchasing\LineItem;

/**
 * @mixin Lineitem
 */
trait LineItemSettersAndGetters
{
    public function getOrderId(): ?string
    {
        return $this->order_id;
    }

    public function setOrderId(?string $order_id): self
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getProductId(): string
    {
        return $this->product_id;
    }

    public function setProductId(string $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getVariationId(): ?string
    {
        return $this->variation_id;
    }

    public function setVariationId(?string $variation_id): self
    {
        $this->variation_id = $variation_id;

        return $this;
    }

    public function getCartId(): string
    {
        return $this->cart_id;
    }

    public function setCartId(string $cart_id): self
    {
        $this->cart_id = $cart_id;

        return $this;
    }

    public function getTaxRateId(): string
    {
        return $this->tax_rate_id;
    }

    public function setTaxRateId(string $tax_rate_id): self
    {
        $this->tax_rate_id = $tax_rate_id;

        return $this;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }
}
