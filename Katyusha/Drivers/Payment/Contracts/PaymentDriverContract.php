<?php

namespace Katyusha\Drivers\Payment\Contracts;

use App\Exceptions\ProviderRequestException;
use Katyusha\Drivers\Payment\Responses\CheckoutRequestResponse;
use Katyusha\Drivers\Payment\Responses\OrderStatusResponse;
use Katyusha\Framework\Money;

interface PaymentDriverContract
{
    /**
     * This will initiate the checkout method
     * It is responsible for calling any internal classes not defined in this contract.
     *
     * @throws ProviderRequestException
     */
    public function initiateCheckout(): CheckoutRequestResponse;

    /**
     * Checks the status of the order. Amount paid, status, etc.
     * Sometimes it needs to sleep to give the end payment system some time to process the order
     * Race race race race race!
     *
     * @throws ProviderRequestException
     */
    public function checkOrderStatus(): ?OrderStatusResponse;

    /**
     * Takes the amount paid and captures it.
     * It should return a status response with the total amount captured.
     */
    public function capture(): ?OrderStatusResponse;

    /**
     * Adds callback info.
     * This shouldn't be, the payment provider client should not update the goddamn order fuck.
     */
    public function addCallbackInfo(object | array $callbackInfo): bool;

    /**
     * Refunds an order.
     */
    public function refund(Money $amount, string $reason = ''): bool;
}
