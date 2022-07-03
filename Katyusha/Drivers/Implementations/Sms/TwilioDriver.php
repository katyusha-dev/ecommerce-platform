<?php

namespace Katyusha\Drivers\Implementations\Sms;

use Katyusha\Drivers\Containers\Sms\SmsSendingContainer;
use Katyusha\Drivers\Contracts\SmsDriverContract;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Api\V2010\Account\MessageInstance;
use Twilio\Rest\Client;

final class TwilioDriver implements SmsDriverContract
{
    public function __construct(protected SmsSendingContainer $container)
    {
    }

    /**
     * @throws TwilioException|ConfigurationException
     */
    public function send(): ?MessageInstance
    {
        $to = '+'.$this->container->countryCode.$this->container->mobile;

        $sender = $this->container->sender;

        if (! $sender || ! ctype_alnum($sender) || mb_strlen($sender) > 7) {
            $sender = config('twilio.default_from');
        }

        return (new Client(config('twilio.sid'), config('twilio.auth_token')))->messages->create($to, ['from' => $sender, 'body' => $this->container->message]);
    }
}
