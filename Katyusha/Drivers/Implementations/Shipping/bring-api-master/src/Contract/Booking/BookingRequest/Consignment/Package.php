<?php

namespace Trafficfox\Bring\API\Contract\Booking\BookingRequest\Consignment;

use InvalidArgumentException;
use Trafficfox\Bring\API\Contract\ApiEntity;
use Trafficfox\Bring\API\Contract\ContractValidationException;

class Package extends ApiEntity
{
    protected $_data = [
        'weightInKg' => null,
        'goodsDescription' => null,
        'dimensions' => [
            'heightInCm' => null,
            'widthInCm' => null,
            'lengthInCm' => null,
        ],
        'containerId' => null,
        'packageType' => null,
        'numberOfItems' => null,
        'correlationId' => null,
    ];

    public function setWeightInKg($weightInKg)
    {
        $val = (float) $weightInKg;

        if ($val < 0) {
            throw new InvalidArgumentException('Argument weightInKg must be greater or equal then zero.');
        }

        return $this->setData('weightInKg', $val);
    }

    public function setGoodsDescription($goodsDescription)
    {
        return $this->setData('goodsDescription', $goodsDescription);
    }

    public function setContainerId($containerId)
    {
        return $this->setData('containerId', $containerId);
    }

    public function setPackageType($packageType)
    {
        return $this->setData('packageType', $packageType);
    }

    public function setNumberOfItems($numberOfItems)
    {
        return $this->setData('numberOfItems', $numberOfItems);
    }

    public function setCorrelationId($correlationId)
    {
        return $this->setData('correlationId', $correlationId);
    }

    public function setDimensionHeightInCm($heightInCm)
    {
        return $this->setDimensionsData('heightInCm', $heightInCm);
    }

    public function setDimensionWidthInCm($widthInCm)
    {
        return $this->setDimensionsData('widthInCm', $widthInCm);
    }

    public function setDimensionLengthInCm($lengthInCm)
    {
        return $this->setDimensionsData('lengthInCm', $lengthInCm);
    }

    public function validate(): void
    {
        if ($this->getData('weightInKg') < 0) {
            throw new ContractValidationException('BookingRequest\Consignment\Package requires "weightInKg" to be greater then zero.');
        }

        if ($this->getDimensionsData('heightInCm') < 0) {
            throw new ContractValidationException('BookingRequest\Consignment\Package requires "heightInCm" to be greater then zero.');
        }

        if ($this->getDimensionsData('widthInCm') < 0) {
            throw new ContractValidationException('BookingRequest\Consignment\Package requires "widthInCm" to be greater then zero.');
        }

        if ($this->getDimensionsData('lengthInCm') < 0) {
            throw new ContractValidationException('BookingRequest\Consignment\Package requires "lengthInCm" to be greater then zero.');
        }
    }

    private function setDimensionsData($key, $value)
    {
        if (! isset($this->_data['dimensions'])) {
            $this->_data['dimensions'] = [];
        }
        $this->_data['dimensions'][$key] = $value;

        return $this;
    }

    private function getDimensionsData($key)
    {
        return $this->_data['dimensions'][$key];
    }
}
