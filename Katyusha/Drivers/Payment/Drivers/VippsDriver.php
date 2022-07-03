<?php

namespace Katyusha\Drivers\Payment\Drivers;

use App\Applications\Economics\Types\Numerical\SafeNumber;
use App\Framework\Utilities\Time;
use Carbon\Carbon;
use function config;
use function Drivers\Implementations\Payments\isLocalEnv;
use Katyusha\Drivers\Payment\Consignments\PaymentRequestConsignment;
use Katyusha\Drivers\Payment\Consignments\VippsApiConsignment;
use Katyusha\Drivers\Payment\Contracts\PaymentDriverContract;
use Katyusha\Drivers\Payment\Drivers\Vipps\Api\Payment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Client;
use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseGetPaymentDetails;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\TransactionInfo;
use Katyusha\Drivers\Payment\Drivers\Vipps\VippsClient;
use Katyusha\Drivers\Payment\Responses\CheckoutRequestResponse;
use Katyusha\Drivers\Payment\Responses\OrderStatusResponse;
use Katyusha\Drivers\Support\Payments\Exceptions\ProviderRequestException;
use Katyusha\Drivers\Support\Payments\OrderStatusParser;
use Katyusha\Drivers\Support\Payments\PaymentOrderStatusRegistry;
use Psr\Http\Client\ClientExceptionInterface;
use stdClass;

/**
 * @property ResponseGetToken token
 * @property VippsClient client
 * @property Authorization auth
 * @property Payment paymentGateway
 */
final class VippsDriver implements PaymentDriverContract
{
    protected int $vippsOrderId;

    public function __construct(protected VippsApiConsignment $apiConsignment, protected PaymentRequestConsignment $paymentRequestConsignment)
    {
        $this->credentials = $requestContainer->apiKeyContainer;
        $this->vippsOrderId = $this->requestContainer->numericOrderId;
    }

    /**
     * Initiates the checkout.
     *
     * @throws ProviderRequestException
     */
    public function initiateCheckout(): CheckoutRequestResponse
    {
        try {
            $timestamp = Carbon::now()->format(Time::DB_TIMESTAMP_FORMAT);
            $mobile = isLocalEnv() ? config('vipps.test_mobile') : $this->requestContainer->customerMobile;

            $response = $this->setGetPaymentGateway()->initiatePayment(
                $this->requestContainer->numericOrderId,
                $this->requestContainer->amount->getAmount(),
                "{$this->requestContainer->shopName} @ ".$timestamp,
                $this->requestContainer->callbackUrl,
                $this->requestContainer->callbackUrl,
                ['mobileNumber' => $mobile, 'refOrderId' => $this->requestContainer->numericOrderId."_${timestamp}"]
            );
        } catch (ClientExceptionInterface | VippsException $exception) {
            throw new ProviderRequestException($exception->getMessage());
        }

        return CheckoutRequestResponse::make($response)
            ->setTransactionId($response->getOrderId())
            ->setOrderInfoRequestToken($response->getOrderId())
            ->setRedirectUrl($response->getURL());
    }

    /**
     * @throws ProviderRequestException
     */
    public function checkOrderStatus(): ?OrderStatusResponse
    {
        try {
            $status = $this->setGetPaymentGateway()->getOrderStatus($this->vippsOrderId);
        } catch (ClientExceptionInterface | VippsException $exception) {
            throw new ProviderRequestException($exception->getMessage());
        }

        return $this->buildOrderStatusResponseFromTransactionInfo($status->getTransactionInfo());
    }

    /**
     * @throws ProviderRequestException
     */
    public function capture(): ?OrderStatusResponse
    {
        try {
            $capture = $this->setGetPaymentGateway()->capturePayment($this->vippsOrderId, config('app.name'), 0);
        } catch (ClientExceptionInterface | VippsException $exception) {
            throw new ProviderRequestException($exception->getMessage());
        }

        return $this->buildOrderStatusResponseFromTransactionInfo($capture->getTransactionInfo());
    }

    public function buildOrderStatusResponseFromTransactionInfo(TransactionInfo $info): OrderStatusResponse
    {
        $res = new OrderStatusResponse($info);
        $status = $info->getStatus();
        $convertedStatus = OrderStatusParser::convertVippsStatus($status);
        $paid = PaymentOrderStatusRegistry::checkStatusAgainstPaidStatuses($convertedStatus);
        $cancelled = PaymentOrderStatusRegistry::checkAgainstCancelledStatus($convertedStatus);
        $statusIsPaid = $convertedStatus === PaymentOrderStatusRegistry::PAID || $convertedStatus === PaymentOrderStatusRegistry::PROCESSING;
        $statusIsCaptured = $convertedStatus === PaymentOrderStatusRegistry::COMPLETE;

        if ($statusIsPaid) {
            $res->setAmountCapturable($info->getAmount());
        }

        if ($statusIsCaptured) {
            $res->setAmountCaptured($info->getAmount());
        }

        return $res
            ->setCancelled($cancelled)
            ->setAmountPaid($info->getAmount())
            ->setApproved($paid)
            ->setProviderStatus($status)
            ->setStatus($convertedStatus);
    }

    /**
     * @throws ProviderRequestException
     */
    public function getPaymentDetails(): ResponseGetPaymentDetails
    {
        try {
            return $this->setGetPaymentGateway()->getPaymentDetails($this->vippsOrderId);
        } catch (ClientExceptionInterface | VippsException $exception) {
            throw new ProviderRequestException($exception->getMessage());
        }
    }

    /**
     * @throws ProviderRequestException
     */
    public function refund(SafeNumber $amount, string $reason = ''): bool
    {
        try {
            $this->setGetPaymentGateway()->refundPayment($this->vippsOrderId, $reason, $amount->castToMinor());
        } catch (ClientExceptionInterface | VippsException $exception) {
            throw new ProviderRequestException($exception->getMessage());
        }

        return true;
    }

    public function addCallbackInfo(array | stdClass $callbackInfo): bool
    {
        return true;
    }

    /**
     * @throws ProviderRequestException
     */
    private function setGetPaymentGateway(): Payment
    {
        $this->client = new VippsClient(new Client($this->credentials->clientId, ['endpoint' => $this->credentials->productionMode ? 'live' : 'test']));
        $this->auth = $this->client->authorization($this->credentials->ecommerceSubscriptionKey);

        try {
            $this->token = $this->auth->getToken($this->credentials->clientSecret);
        } catch (ClientExceptionInterface | VippsException $exception) {
            throw new ProviderRequestException($exception->getMessage());
        }

        $this->paymentGateway = $this->client->payment($this->credentials->ecommerceSubscriptionKey, $this->credentials->merchantSerialNumber);

        return $this->paymentGateway;
    }
}
