<?php

namespace Trafficfox\Bring\API\Contract\Booking\BookingRequest\Consignment;

use InvalidArgumentException;
use Trafficfox\Bring\API\Contract\ApiEntity;
use Trafficfox\Bring\API\Contract\ContractValidationException;
use Trafficfox\Bring\API\Data\BringData;

class Product extends ApiEntity
{
    public const ADDITIONAL_SERVICE_CASH_ON_DELIVERY = 'cashOnDelivery';
    public const ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION = 'recipientNotification';
    public const ADDITIONAL_SERVICE_SOCIAL_CONTROL = 'socialControl';
    public const ADDITIONAL_SERVICE_SIMPLE_DELIVERY = 'simpleDelivery';
    public const ADDITIONAL_SERVICE_DELIVERY_OPTION = 'deliveryOption';
    public const ADDITIONAL_SERVICE_SATURDAY_DELIVERY = 'saturdayDelivery';
    public const ADDITIONAL_SERVICE_FLEX_DELIVERY = 'flexDelivery';
    public const ADDITIONAL_SERVICE_PHONE_NOTIFICATION = 'phonenotification';
    public const ADDITIONAL_SERVICE_DELIVERY_INDOORS = 'deliveryIndoors';
    protected $_data = [
        'services' => null,
        'customsDeclaration' => null,
    ];

    /**
     * See http://developer.bring.com/api/booking/.
     */
    public static function serviceMapping()
    {
        return [
            BringData::PRODUCT_SERVICEPAKKE => [self::ADDITIONAL_SERVICE_CASH_ON_DELIVERY, self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_SOCIAL_CONTROL],
            BringData::PRODUCT_BPAKKE_DOR_DOR => [self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_SIMPLE_DELIVERY, self::ADDITIONAL_SERVICE_DELIVERY_OPTION],
            BringData::PRODUCT_EKSPRESS09 => [self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_SATURDAY_DELIVERY],
            BringData::PRODUCT_PICKUP_PARCEL => [self::ADDITIONAL_SERVICE_CASH_ON_DELIVERY, self::ADDITIONAL_SERVICE_FLEX_DELIVERY, self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_DELIVERY_OPTION],
            BringData::PRODUCT_PICKUP_PARCEL_BULK => [self::ADDITIONAL_SERVICE_CASH_ON_DELIVERY, self::ADDITIONAL_SERVICE_FLEX_DELIVERY, self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_DELIVERY_OPTION],
            BringData::PRODUCT_HOME_DELIVERY_PARCEL => [self::ADDITIONAL_SERVICE_CASH_ON_DELIVERY, self::ADDITIONAL_SERVICE_FLEX_DELIVERY, self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION],
            BringData::PRODUCT_BUSINESS_PARCEL => [self::ADDITIONAL_SERVICE_CASH_ON_DELIVERY, self::ADDITIONAL_SERVICE_FLEX_DELIVERY, self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_PHONE_NOTIFICATION, self::ADDITIONAL_SERVICE_DELIVERY_INDOORS],
            BringData::PRODUCT_BUSINESS_PARCEL_BULK => [self::ADDITIONAL_SERVICE_CASH_ON_DELIVERY, self::ADDITIONAL_SERVICE_FLEX_DELIVERY, self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_PHONE_NOTIFICATION, self::ADDITIONAL_SERVICE_DELIVERY_INDOORS],
            BringData::PRODUCT_EXPRESS_NORDIC_0900_BULK => [self::ADDITIONAL_SERVICE_CASH_ON_DELIVERY, self::ADDITIONAL_SERVICE_FLEX_DELIVERY, self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_PHONE_NOTIFICATION, self::ADDITIONAL_SERVICE_DELIVERY_INDOORS],
            BringData::PRODUCT_BUSINESS_PALLET => [self::ADDITIONAL_SERVICE_FLEX_DELIVERY, self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_PHONE_NOTIFICATION, self::ADDITIONAL_SERVICE_DELIVERY_INDOORS],
            BringData::PRODUCT_BUSINESS_PARCEL_HALFPALLET => [self::ADDITIONAL_SERVICE_FLEX_DELIVERY, self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_PHONE_NOTIFICATION, self::ADDITIONAL_SERVICE_DELIVERY_INDOORS],
            BringData::PRODUCT_BUSINESS_PARCEL_QUARTERPALLET => [self::ADDITIONAL_SERVICE_FLEX_DELIVERY, self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_PHONE_NOTIFICATION, self::ADDITIONAL_SERVICE_DELIVERY_INDOORS],
            BringData::PRODUCT_EXPRESS_NORDIC_0900 => [self::ADDITIONAL_SERVICE_FLEX_DELIVERY, self::ADDITIONAL_SERVICE_RECIPIENT_NOTIFICATION, self::ADDITIONAL_SERVICE_PHONE_NOTIFICATION, self::ADDITIONAL_SERVICE_DELIVERY_INDOORS],
        ];
    }

    public function setId($id): void
    {
        if (! in_array($id, BringData::validProducts())) {
            throw new InvalidArgumentException("${id} is not a valid product. Valid products are: ".implode(', ', self::VALID_PRODUCTS));
        }
        $this->setData('id', $id);
    }

    public function setCustomerNumber($customerNumber): void
    {
        $this->setData('customerNumber', $customerNumber);
    }

    public function addService($service): void
    {
        $this->addData('services', $service);
    }

    public function setServices($services): void
    {
        $this->_data['services'] = $services;
    }

    public function validate(): void
    {
        if (! $this->containsData('id') || ! $this->getData('id')) {
            throw new ContractValidationException('BookingRequest\Consignment\Product requires "id" to be set.');
        }

        if (! $this->containsData('customerNumber') || ! $this->getData('customerNumber')) {
            throw new ContractValidationException('BookingRequest\Consignment\Product requires "customerNumber" to be set.');
        }

        // Check service mapping..
        $packageId = $this->getData('id');

        if ($services = $this->getData('services')) {
            $map = self::serviceMapping();
            $allowed_services = $map[$packageId];
            foreach ($services as $service => $value) {
                if (! in_array($service, $allowed_services)) {
                    throw new ContractValidationException('BookingRequest\Consignment\Product has invalid service set ("'.$service.'"). Allowed services are: '.implode(',', $allowed_services));
                }
            }
        }
    }
}
