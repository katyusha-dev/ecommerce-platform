<?php

namespace Trafficfox\Bring\API\Data;

/**
 * Created by PhpStorm.
 * User: Trafficfox
 * Date: 5/24/16
 * Time: 10:34 PM.
 */

class ShippingGuideData
{
    public const EVARSLING = 'EVARSLING';
    public const POSTOPPKRAV = 'POSTOPPKRAV';
    public const LORDAGSUTKJORING = 'LORDAGSUTKJORING';
    public const ENVELOPE = 'ENVELOPE';
    public const ADVISERING = 'ADVISERING';
    public const PICKUP_POINT = 'PICKUP_POINT';
    public const EVE_DELIVERY = 'EVE_DELIVERY';

    public static function validAdditionalServices()
    {
        return [
            self::EVARSLING,
            self::POSTOPPKRAV,
            self::LORDAGSUTKJORING,
            self::ENVELOPE,
            self::ADVISERING,
            self::PICKUP_POINT,
            self::EVE_DELIVERY,
        ];
    }
}
