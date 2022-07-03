<?php

namespace Features\Purchasing\Models\SettersAndGetters;

use Carbon\Carbon;

/**
 * @mixin \Features\Purchasing\Models\CartModel
 */
trait CartSettersAndGetters
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

    public function getOrderId(): ?string
    {
        return $this->order_id;
    }

    public function setOrderId(?string $order_id): self
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getAttemptedCheckoutAt(): ?Carbon
    {
        return $this->attempted_checkout_at;
    }

    public function setAttemptedCheckoutAt(?Carbon $attempted_checkout_at): self
    {
        $this->attempted_checkout_at = $attempted_checkout_at;

        return $this;
    }
}
