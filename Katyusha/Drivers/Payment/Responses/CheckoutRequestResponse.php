<?php

namespace Katyusha\Drivers\Payment\Responses;

final class CheckoutRequestResponse
{
    public ?string $redirectUrl = null;
    public ?int $amountPayable = 0;
    public ?int $amountRequested = 0;
    public array $frontendParams = [];
    public ?string $transactionId = null;
    public ?string $orderInfoRequestToken = null;

    public function __construct(public object $response)
    {
    }

    public static function make(object $response): self
    {
        return new self($response);
    }

    public function setRedirectUrl(?string $redirectUrl): self
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    public function addFrontendParam(string $key, mixed $value): self
    {
        $this->frontendParams[$key] = $value;

        return $this;
    }

    public function setPaymentHtml(?string $paymentHtml): self
    {
        $this->paymentHtml = $paymentHtml;

        return $this;
    }

    public function setOrderInfoRequestToken(string $orderInfoRequestToken): self
    {
        $this->orderInfoRequestToken = $orderInfoRequestToken;

        return $this;
    }

    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }
}
