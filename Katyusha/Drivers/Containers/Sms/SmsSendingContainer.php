<?php

namespace Katyusha\Drivers\Containers\Sms;

class SmsSendingContainer
{
    public function __construct(public int $countryCode, public int $mobile, public string $message, public ?string $sender = null)
    {
    }
}
