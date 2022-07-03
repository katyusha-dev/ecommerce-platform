<?php

namespace Katyusha\Drivers\Managers;

use Illuminate\Support\Manager;
use Katyusha\Drivers\Containers\Sms\SmsSendingContainer;
use Katyusha\Drivers\Contracts\SmsDriverContract;
use Katyusha\Drivers\Implementations\Sms\TwilioDriver;

/**
 * @method SmsDriverContract driver(string $driver = null)
 */
final class SmsManager extends Manager
{
    public const TWILIO = 'twilio';

    protected SmsSendingContainer $smsContainer;

    public function getDefaultDriver(): string
    {
        return config('drivers.sms.default');
    }

    public function setRequestContainer(SmsSendingContainer $container): self
    {
        $this->smsContainer = $container;

        return $this;
    }

    public function createTwilioDriver(): SmsDriverContract
    {
        return new TwilioDriver($this->smsContainer);
    }
}
