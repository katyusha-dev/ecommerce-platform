<?php

namespace Features\Purchasing\Models\SettersAndGetters;

use Carbon\Carbon;
use Features\Purchasing\Enums\PaymentProvidersEnum;
use Katyusha\Framework\Money;

trait PaymentSettersAndGetters
{
    public function getOrderId(): string
    {
        return $this->order_id;
    }

    public function setOrderId(string $order_id): self
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getTotalWithoutTax(): Money
    {
        return $this->total_without_tax;
    }

    public function setTotalWithoutTax(Money $total_without_tax): self
    {
        $this->total_without_tax = $total_without_tax;

        return $this;
    }

    public function getTax(): Money
    {
        return $this->tax;
    }

    public function setTax(Money $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getNumericId(): int
    {
        return $this->numeric_id;
    }

    public function setNumericId(int $numeric_id): self
    {
        $this->numeric_id = $numeric_id;

        return $this;
    }

    public function setAmount(Money $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaymentMethod(): PaymentProvidersEnum
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(PaymentProvidersEnum $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function isApproved(): bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function isCancelled(): bool
    {
        return $this->cancelled;
    }

    public function setCancelled(bool $cancelled): self
    {
        $this->cancelled = $cancelled;

        return $this;
    }

    public function isDeclined(): bool
    {
        return $this->declined;
    }

    public function setDeclined(bool $declined): self
    {
        $this->declined = $declined;

        return $this;
    }

    public function getAmountPaid(): ?Money
    {
        return $this->amount_paid;
    }

    public function setAmountPaid(?Money $amount_paid): self
    {
        $this->amount_paid = $amount_paid;

        return $this;
    }

    public function getAmountCaptured(): ?Money
    {
        return $this->amount_captured;
    }

    public function setAmountCaptured(?Money $amount_captured): self
    {
        $this->amount_captured = $amount_captured;

        return $this;
    }

    public function isComplete(): bool
    {
        return $this->complete;
    }

    public function setComplete(bool $complete): self
    {
        $this->complete = $complete;

        return $this;
    }

    public function getAttemptedPaymentAt(): ?Carbon
    {
        return $this->attempted_payment_at;
    }

    public function setAttemptedPaymentAt(?Carbon $attempted_payment_at): self
    {
        $this->attempted_payment_at = $attempted_payment_at;

        return $this;
    }

    public function getCompletedPaymentAt(): ?Carbon
    {
        return $this->completed_payment_at;
    }

    public function setCompletedPaymentAt(?Carbon $completed_payment_at): self
    {
        $this->completed_payment_at = $completed_payment_at;

        return $this;
    }
}
