<?php

namespace Trafficfox\Bring\API\Contract\EasyReturn\LabelRequest;

use Trafficfox\Bring\API\Contract\ContractValidationException;

class Shipment extends \Trafficfox\Bring\API\Contract\ApiEntity
{
    protected $_data = [
        'PackageId' => null,
        'ShipmentId' => null,
        'CustomerReference' => null,
        'ProductCode' => null,
        'Weight' => null,
    ];

    public function setPackageId($name)
    {
        return $this->setData('PackageId', $name);
    }

    public function setShipmentId($name)
    {
        return $this->setData('ShipmentId', $name);
    }

    public function setCustomerReference($name)
    {
        return $this->setData('CustomerReference', $name);
    }

    public function setProductCode($name)
    {
        return $this->setData('ProductCode', $name);
    }

    public function setWeight($name)
    {
        return $this->setData('Weight', $name);
    }

    public function validate(): void
    {
        if (! $this->getData('PackageId')) {
            throw new ContractValidationException('Shipment requires "PackageId" attribute to be set.');
        }

        if (! $this->getData('ShipmentId')) {
            throw new ContractValidationException('Shipment requires "ShipmentId" attribute to be set.');
        }

        if (! $this->getData('ProductCode')) {
            throw new ContractValidationException('Shipment requires "ProductCode" attribute to be set.');
        }

        if (! $this->getData('Weight')) {
            throw new ContractValidationException('Shipment requires "Weight" attribute to be set.');
        }
    }
}
