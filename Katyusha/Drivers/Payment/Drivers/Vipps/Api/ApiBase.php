<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Api;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\Api\InvalidArgumentException;
use Katyusha\Drivers\Payment\Drivers\Vipps\VippsInterface;

abstract class ApiBase
{
    protected VippsInterface $app;

    protected string $subscriptionKey;

    /**
     * ApiBase constructor.
     */
    public function __construct(VippsInterface $app, string $subscription_key)
    {
        $this->app = $app;
        $this->subscriptionKey = $subscription_key;
    }

    /**
     * Gets subscription_key value.
     */
    public function getSubscriptionKey(): string
    {
        if (empty($this->subscriptionKey)) {
            throw new InvalidArgumentException('Missing subscription key');
        }

        return $this->subscriptionKey;
    }

    /**
     * Sets subscription_key variable.
     *
     * @return $this
     */
    public function setSubscriptionKey(string $subscriptionKey)
    {
        $this->subscriptionKey = $subscriptionKey;

        return $this;
    }
}
