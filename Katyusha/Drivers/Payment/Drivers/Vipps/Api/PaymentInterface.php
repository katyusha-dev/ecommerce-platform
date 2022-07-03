<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Api;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseCancelPayment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseCapturePayment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseGetOrderStatus;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseGetPaymentDetails;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseInitiatePayment;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment\ResponseRefundPayment;

/**
 * Interface PaymentInterface.
 */
interface PaymentInterface
{
    public function cancelPayment(string $order_id, string $text): ResponseCancelPayment;

    public function capturePayment(string $order_id, string $text, int $amount = 0): ResponseCapturePayment;

    /**
     * @throws VippsException
     *
     * @deprecated Get order status was deprecated and can be removed in version 3.0.
     *
     * @see \Drivers\Payment\Drivers\Vipps\Resource\Payment\GetOrderStatus
     */
    public function getOrderStatus(string $order_id): ResponseGetOrderStatus;

    public function getPaymentDetails(string $order_id): ResponseGetPaymentDetails;

    /**
     * @param $options array
     *   Optional values.
     *
     * @throws VippsException
     *
     * @see https://vippsas.github.io/vipps-ecom-api/#/Vipps_eCom_API/initiatePaymentV3UsingPOST
     */
    public function initiatePayment(string $order_id, int $amount, string $text, string $callbackPrefix, string $fallback, $options = []): ResponseInitiatePayment;

    public function refundPayment(string $order_id, string $text, int $amount = 0): ResponseRefundPayment;
}
