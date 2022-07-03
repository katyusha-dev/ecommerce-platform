<?php

namespace Katyusha\Drivers\Payment\Drivers;

use App\Exceptions\PaymentProviderException;
use Katyusha\Drivers\Payment\Consignments\PaymentRequestConsignment;
use Katyusha\Drivers\Payment\Consignments\StripeApiConsignment;
use Katyusha\Drivers\Payment\Contracts\PaymentDriverContract;
use Katyusha\Drivers\Payment\Responses\CheckoutRequestResponse;
use Katyusha\Drivers\Payment\Responses\OrderStatusResponse;
use Katyusha\Framework\Money;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe as StripeBase;
use Stripe\StripeClient;

/**
 * @property StripeClient client
 */
final class StripeDriver implements PaymentDriverContract
{
    public function __construct(protected StripeApiConsignment $apiConsignment, protected PaymentRequestConsignment $paymentRequestConsignment)
    {
        $this->client = new StripeClient($apiConsignment->secretKey);

        StripeBase::setApiKey($apiConsignment->secretKey);
    }

    /**
     * @throws PaymentProviderException
     */
    public function getPaymentIntent(): PaymentIntent
    {
        try {
            return $this->client->paymentIntents->retrieve($this->order->getProviderTransactionId());
        } catch (ApiErrorException $exception) {
            throw new PaymentProviderException($exception->getMessage());
        }
    }

    /**
     * @throws PaymentProviderException
     */
    public function createPaymentIntent(): PaymentIntent
    {
        try {
            return PaymentIntent::create([
                'amount' => $this->paymentRequestConsignment->amount->getAmount(),
                'currency' => mb_strtolower($this->paymentRequestConsignment->currency),
                'metadata' => ['integration_check' => 'accept_a_payment'],
            ]);
        } catch (ApiErrorException $exception) {
            throw new PaymentProviderException($exception->getMessage());
        }
    }

    /**
     * @throws PaymentProviderException
     */
    public function initiateCheckout(): CheckoutRequestResponse
    {
        $intent = $this->createPaymentIntent();

        $response = new CheckoutRequestResponse($intent);
        $response->amountPayable = $intent->amount;
        $response->amountRequested = $this->paymentRequestConsignment->amount->getAmount();

        return $response
            ->addFrontendParam('client_secret', $intent->client_secret)
            ->addFrontendParam('public_key', $this->apiConsignment->publishableKey)
            ->addFrontendParam('test_mode', $this->apiConsignment->testMode)
            ->setTransactionId($intent->id);
    }

    /**
     * @throws PaymentProviderException
     */
    public function checkOrderStatus(): ?OrderStatusResponse
    {
        $intent = $this->getPaymentIntent();
        $status = OrderStatusParser::convertStripeStatus($intent->status);
        $isApproved = PaymentOrderStatusRegistry::checkStatusAgainstPaidStatuses($status);

        return OrderStatusResponse::make($intent)
            ->setStatus($status)
            ->setApproved($isApproved)
            ->setProviderStatus($intent->status)
            ->setCancelled((bool) $intent->canceled_at)
            ->setAmountPaid($intent->amount_received)
            ->setAmountCaptured($intent->amount_received)
            ->setAmountCapturable($intent->amount_capturable);
    }

    public function addCallbackInfo(array | object $callbackInfo): bool
    {
        // TODO: Implement addCallbackInfo() method.
    }

    public function refund(Money $amount, string $reason = ''): bool
    {
        // TODO: Implement refund() method.
    }

    public function capture(): ?OrderStatusResponse
    {
        // TODO: Implement capture() method.
    }
}
