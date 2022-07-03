<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class MerchantInfo.
 */
class MerchantInfo
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected ?string $authToken = null;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected ?string $merchantSerialNumber = null;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected ?string $callbackPrefix = null;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected ?string $fallBack = null;

    /**
     * @JMS\Serializer\Annotation\Type("boolean")
     */
    protected ?bool $isApp = null;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected ?string $consentRemovalPrefix = null;

    /**
     * @var string ['eComm Regular Payment', 'eComm Express Payment']
     *
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected ?string $paymentType = null;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected ?string $shippingDetailsPrefix = null;

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    /**
     * @return $this
     */
    public function setAuthToken(string $authToken)
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * Gets merchantSerialNumber value.
     */
    public function getMerchantSerialNumber(): string
    {
        return $this->merchantSerialNumber;
    }

    /**
     * Sets merchantSerialNumber variable.
     *
     * @return $this
     */
    public function setMerchantSerialNumber(string $merchantSerialNumber)
    {
        $this->merchantSerialNumber = $merchantSerialNumber;

        return $this;
    }

    /**
     * Gets callBack value.
     */
    public function getCallbackPrefix(): string
    {
        return $this->callbackPrefix;
    }

    /**
     * Sets callbackPrefix variable.
     *
     * @return $this
     */
    public function setCallbackPrefix(string $callbackPrefix)
    {
        $this->callbackPrefix = $callbackPrefix;

        return $this;
    }

    /**
     * Gets consentRemovalPrefix value.
     */
    public function getConsentRemovalPrefix(): string
    {
        return $this->consentRemovalPrefix;
    }

    /**
     * Sets consentRemovalPrefix variable.
     *
     * @return $this
     */
    public function setConsentRemovalPrefix(string $consentRemovalPrefix)
    {
        $this->consentRemovalPrefix = $consentRemovalPrefix;

        return $this;
    }

    /**
     * Gets fallBack value.
     */
    public function getFallBack(): string
    {
        return $this->fallBack;
    }

    /**
     * Sets fallBack variable.
     *
     * @return $this
     */
    public function setFallBack(string $fallBack)
    {
        $this->fallBack = $fallBack;

        return $this;
    }

    public function isApp(): string
    {
        return $this->isApp;
    }

    /**
     * @return $this
     */
    public function setIsApp(string $isApp)
    {
        $this->isApp = $isApp;

        return $this;
    }

    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    /**
     * @return $this
     */
    public function setPaymentType(string $paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    public function getShippingDetailsPrefix(): string
    {
        return $this->shippingDetailsPrefix;
    }

    /**
     * @return $this
     */
    public function setShippingDetailsPrefix(string $shippingDetailsPrefix)
    {
        $this->shippingDetailsPrefix = $shippingDetailsPrefix;

        return $this;
    }
}
