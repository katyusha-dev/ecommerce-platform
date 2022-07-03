<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Authorization;

use DateTimeInterface;

/**
 * Class ResponseGetToken.
 */
class ResponseGetToken
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $tokenType;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $expiresIn;

    /**
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected int $extExpiresIn;

    /**
     * @JMS\Serializer\Annotation\Type("DateTime<'U'>")
     */
    protected DateTimeInterface $expiresOn;

    /**
     * @JMS\Serializer\Annotation\Type("DateTime<'U'>")
     */
    protected DateTimeInterface $notBefore;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $resource;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $accessToken;

    /**
     * Gets accessToken value.
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Gets expiresIn value.
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * Gets expiresOn value.
     */
    public function getExpiresOn(): DateTimeInterface
    {
        return $this->expiresOn;
    }

    /**
     * Gets extExpiresIn value.
     */
    public function getExtExpiresIn(): int
    {
        return $this->extExpiresIn;
    }

    /**
     * Gets notBefore value.
     */
    public function getNotBefore(): DateTimeInterface
    {
        return $this->notBefore;
    }

    /**
     * Gets resource value.
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * Gets tokenType value.
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }
}
