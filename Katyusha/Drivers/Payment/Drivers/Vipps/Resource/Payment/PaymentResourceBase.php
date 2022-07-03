<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource\Payment;

use DateTime;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;
use Katyusha\Drivers\Payment\Drivers\Vipps\Resource\AuthorizedResourceBase;
use Katyusha\Drivers\Payment\Drivers\Vipps\Resource\RequestIdFactory;
use Katyusha\Drivers\Payment\Drivers\Vipps\VippsInterface;

/**
 * Class PaymentResourceBase.
 */
abstract class PaymentResourceBase extends AuthorizedResourceBase
{
    public function __construct(VippsInterface $vipps, $subscription_key)
    {
        parent::__construct($vipps, $subscription_key);

        // Adjust serializer.
        $this->serializer = SerializerBuilder::create()
            ->setPropertyNamingStrategy(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()))
            ->build();

        // Content type for all requests must be set.
        $this->headers['Content-Type'] = 'application/json';

        // By default RequestID is different for each Resource object.
        $this->headers['X-Request-Id'] = RequestIdFactory::generate();

        // Timestamp is equal to current DateTime.
        $format = DateTime::ISO8601;
        $this->headers['X-TimeStamp'] = (new DateTime())->format($format);
    }
}
