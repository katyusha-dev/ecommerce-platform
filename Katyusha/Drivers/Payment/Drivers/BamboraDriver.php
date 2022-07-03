<?php

namespace Katyusha\Drivers\Payment\Drivers;

use App\Applications\Economics\Types\Numerical\SafeNumber;
use App\Exceptions\OrderPaymentException;
use App\Exceptions\RefundException;
use App\Framework\Utilities\Arr;
use function Drivers\Implementations\Payments\base64_encode;
use function Drivers\Implementations\Payments\curl_exec;
use function Drivers\Implementations\Payments\curl_init;
use function Drivers\Implementations\Payments\curl_setopt;
use function Drivers\Implementations\Payments\is_array;
use function Drivers\Implementations\Payments\is_null;
use Features\Orders\Containers\OrderPaymentRequestContainer;
use Illuminate\Support\Str;
use Katyusha\Drivers\Payment\Contracts\PaymentDriverContract;
use Katyusha\Drivers\Payment\Responses\CheckoutRequestResponse;
use Katyusha\Drivers\Payment\Responses\OrderStatusResponse;
use Katyusha\Drivers\Support\Payments\Exceptions\ProviderRequestException;
use Katyusha\Drivers\Support\Payments\OrderStatusParser;
use Throwable;

final class BamboraDriver implements PaymentDriverContract
{
    public const API_URL = 'https://api.v1.checkout.bambora.com';
    public const MERCHANT_URL = 'https://merchant-v1.api-eu.bambora.com';
    public const TRANSACTION_URL_BASE = 'https://transaction-v1.api-eu.bambora.com';
    public const CHECKOUT_SESSION_URL = self::API_URL.'/sessions';
    public const MERCHANT_TRANSACTIONS_URL = self::MERCHANT_URL.'/transactions';
    public const TRANSACTIONS_URL = self::TRANSACTION_URL_BASE.'/transactions';
    public const TRANSACTION_URL = '/transactions/{transactionId}';
    public const TRANSACTION_CAPTURE_URL = '/transactions/{transactionId}/capture';
    public const TRANSACTION_CREDIT_URL = '/transactions/{transactionId}/credit';

    protected string $apiKey;

    public function __construct(protected OrderPaymentRequestContainer $requestContainer)
    {
        $this->apiKey = base64_encode($this->credentials->getAccessToken().'@'.$this->credentials->getMerchantNumber().':'.$this->credentials->getSecretToken());
    }

    /**
     * @throws ProviderRequestException
     */
    public function addCallbackInfo(array | object $callbackInfo): bool
    {
        $callbackInfo = Arr::toObject($callbackInfo);

        if (! isset($callbackInfo->txnid)) {
            return false;
        }

        if ($this->order->getProviderTransactionId() && $this->order->getProviderTransactionId() !== $callbackInfo->txnid) {
            throw new ProviderRequestException('Order already has payment provider transaction ID');
        }

        $this->order->setProviderTransactionId($callbackInfo->txnid)->setCallbackResponse($callbackInfo)->saveAndReturnModel();

        return true;
    }

    /**
     * @throws ProviderRequestException
     */
    public function initiateCheckout(): CheckoutRequestResponse
    {
        $response = $this->post(self::CHECKOUT_SESSION_URL, $this->getCheckoutRequestObject());

        $requestResponse = new CheckoutRequestResponse($response);
        $requestResponse->redirectUrl = $response->url ?? null;
        $requestResponse->orderInfoRequestToken = $response->token ?? null;

        if (! $requestResponse->orderInfoRequestToken || ! $requestResponse->redirectUrl) {
            throw ProviderRequestException::make('Bambora response is incomplete/incorrect')->setResponseObject($response);
        }

        return $requestResponse;
    }

    /**
     * @throws ProviderRequestException|RefundException
     */
    public function refund(SafeNumber $amount): bool
    {
        $response = $this->post(self::TRANSACTIONS_URL.'/'.$this->order->getProviderTransactionId().'/credit', ['amount' => $amount->getValue()]);
        $refunded = $response->meta?->action?->type === 'success';

        if (! $refunded) {
            throw new RefundException($response->meta->message->merchant);
        }

        return $refunded;
    }

    /**
     * @throws ProviderRequestException|OrderPaymentException
     */
    public function checkOrderStatus(): ?OrderStatusResponse
    {
        // Sleep because fuck it, it needs it sometimes
//        sleep(3);

        if (! $transactionId = $this->order->getProviderTransactionId()) {
            throw new ProviderRequestException('No provider transaction ID for order: '.$this->order->getProviderTransactionId());
        }

        $response = $this->get(self::MERCHANT_TRANSACTIONS_URL.'/'.$transactionId);

        $responseObject = new OrderStatusResponse($response);

        if (! isset($response->transaction)) {
            throw new ProviderRequestException($response);
        }

        $transaction = $response->transaction;
        $total = $transaction->total;

        $responseObject
            ->setStatus($transaction->status)
            ->setAmountPaid($total->authorized)
            ->setAmountPaid($total->authorized)
            ->setAmountCaptured($total->captured)
            ->setProviderStatus($transaction->status)
            ->setAmountCapturable($total->authorized)
            ->setApproved($transaction->status === 'approved')
            ->setCancelled($transaction->status !== 'approved')
            ->setStatus(OrderStatusParser::convertBamboraStatus($transaction->status));

        return $responseObject;
    }

    /**
     * @throws ProviderRequestException
     */
    public function capture(): ?OrderStatusResponse
    {
    }

    protected function getCheckoutRequestObject(): array
    {
        $request = [
            'instantcaptureamount' => $order->isInstantCapture() ? $order->getAmount() : 0,
            'securitylevel' => 'none',
        ];

        $request['order'] = [];
        $request['order']['id'] = $order->getIntegerId();
        $request['order']['amount'] = $order->getAmount();
        $request['order']['currency'] = 'NOK';
        $request['order']['store'] = ['name' => $order->getStoreName()];

        $request['url'] = [];
        $request['url']['accept'] = $order->getSuccessUrl();
        $request['url']['immediateredirecttoaccept'] = 1;
        $request['url']['cancel'] = $order->getCancelUrl();
        $request['url']['callbacks'] = [];
        $request['url']['callbacks'][] = ['url' => $order->getOnSiteCallbackUrl()];
        $request['paymentwindow'] = ['language' => 'nb-NO'];

        return $request;
    }

    /**
     * @throws ProviderRequestException
     */
    protected function post(string $path, array | object $requestObject): object
    {
        $json = is_array($requestObject) ? json_encode($requestObject) : json_encode($requestObject->getObject());
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_URL, $path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders($json));
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $rawResponse = curl_exec($curl);
        $res = json_decode($rawResponse);

        if (is_null($res)) {
            throw new ProviderRequestException($rawResponse);
        }

        return $res;
    }

    /**
     * @throws OrderPaymentException
     */
    protected function get(string $path): object
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_URL, $path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders(''));
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        try {
            $rawResponse = curl_exec($curl);
        } catch (Throwable $exception) {
            throw new OrderPaymentException("${path}: ".$exception->getMessage(), $exception);
        }

        $res = json_decode($rawResponse);

        if (! $res) {
            throw new OrderPaymentException("${path}: ".$rawResponse);
        }

        return $res;
    }

    private function getHeaders(?string $requestJSON = null): array
    {
        return ['Content-Type: application/json', 'Content-Length: '.Str::length($requestJSON), 'Accept: application/json', 'Authorization: Basic '.$this->apiKey];
    }
}
