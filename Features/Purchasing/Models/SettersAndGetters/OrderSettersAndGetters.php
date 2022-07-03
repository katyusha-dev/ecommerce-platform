<?php

namespace Features\Purchasing\Models\SettersAndGetters;

/**
 * @mixin \Features\Purchasing\Models\OrderModel
 */
trait OrderSettersAndGetters
{
    public function getSessionId(): ?string
    {
        return $this->session_id;
    }

    public function setSessionId(?string $session_id): self
    {
        $this->session_id = $session_id;

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

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(?string $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function isPaid(): bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }
}
