<?php

namespace Trafficfox\Bring\API\Contract\Booking\BookingRequest\Consignment;

use Trafficfox\Bring\API\Contract\ApiEntity;
use Trafficfox\Bring\API\Contract\ContractValidationException;

class Address extends ApiEntity
{
    protected $_data = [
        'name' => null,
        'addressLine' => null,
        'addressLine2' => null,
        'postalCode' => null,
        'city' => null,
        'countryCode' => null,
        'reference' => null,
        'contact' => null,
        'additionalAddressInfo' => null,
    ];

    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    public function setAddressLine($addressLine)
    {
        return $this->setData('addressLine', $addressLine);
    }

    public function setAddressLine2($addressLine2)
    {
        return $this->setData('addressLine2', $addressLine2);
    }

    public function setPostalCode($postalCode)
    {
        return $this->setData('postalCode', $postalCode);
    }

    public function setCity($city)
    {
        return $this->setData('city', $city);
    }

    public function setCountryCode($countryCode)
    {
        return $this->setData('countryCode', $countryCode);
    }

    public function setReference($reference)
    {
        return $this->setData('reference', $reference);
    }

    public function setAdditionalAddressInfo($additionalAddressInfo)
    {
        return $this->setData('additionalAddressInfo', $additionalAddressInfo);
    }

    public function setContact(Contact $contact): void
    {
        $this->setData('contact', $contact);
    }

    public function validate(): void
    {
        $required_fields = ['name', 'addressLine', 'postalCode', 'city', 'countryCode'];

        foreach ($required_fields as $f) {
            if (! $this->getData($f)) {
                throw new ContractValidationException('BookingRequest\Consignment\Address requires "'.$f.'" to be set.');
            }
        }
    }
}
