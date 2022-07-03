<?php

/**
 * Payment interface.
 *
 * Interface which defines payments.
 */

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource;

/**
 * Interface PaymentsInterface.
 */
interface PaymentsInterface extends ResourceInterface
{
    /**
     * Set Order ID for payment.
     */
    public function setOrderID(string $orderID): self;

    /**
     * Create new payment.
     */
    public function create(int $mobileNumber, int $amount, string $text, string $callback, string $fallback, ?string $refOrderID = null): self;

    /**
     * Cancel payment.
     */
    public function cancel(string $text): self;

    /**
     * Capture payment.
     */
    public function capture(string $text, int $amount = 0): self;

    /**
     * Refund payment.
     */
    public function refund(string $text, int $amount = 0): self;

    /**
     * Get payment status.
     */
    public function getStatus(): mixed;

    /**
     * Get payment details.
     */
    public function getDetails(): mixed;
}
