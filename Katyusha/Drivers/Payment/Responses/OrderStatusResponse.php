<?php

namespace Katyusha\Drivers\Payment\Responses;

final class OrderStatusResponse
{
    public ?int $amountPaid = null;
    public ?int $amountCaptured = null;
    public ?int $amountCapturable = null;
    public ?string $providerStatus = null;
    public ?string $status = null;
    public ?bool $approved = null;
    public ?bool $declined = null;
    public ?bool $cancelled = null;

    public function __construct(public object $response)
    {
    }

    public function setAmountPaid(?int $amountPaid): self
    {
        $this->amountPaid = $amountPaid;

        return $this;
    }

    public function setAmountCaptured(?int $amountCaptured): self
    {
        $this->amountCaptured = $amountCaptured;

        return $this;
    }

    public function setAmountCapturable(?int $amountCapturable): self
    {
        $this->amountCapturable = $amountCapturable;

        return $this;
    }

    public function setProviderStatus(?string $providerStatus): self
    {
        $this->providerStatus = $providerStatus;

        return $this;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setApproved(?bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function setDeclined(?bool $declined): self
    {
        $this->declined = $declined;

        return $this;
    }

    public function setCancelled(?bool $cancelled): self
    {
        $this->cancelled = $cancelled;

        return $this;
    }
}
