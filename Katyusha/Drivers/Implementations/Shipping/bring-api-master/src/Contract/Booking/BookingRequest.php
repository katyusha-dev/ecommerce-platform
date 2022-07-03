<?php

namespace Trafficfox\Bring\API\Contract\Booking;

use Trafficfox\Bring\API\Contract\ApiEntity;
use Trafficfox\Bring\API\Contract\ContractValidationException;

class BookingRequest extends ApiEntity
{
    public const SCHEMA_VERSION = 1;

    protected $_data = [
        'testIndicator' => true,
        'schemaVersion' => self::SCHEMA_VERSION,
        'consignments' => [],
    ];

    public function setTestIndicator($testIndicator)
    {
        return $this->setData('testIndicator', $testIndicator);
    }

    public function addConsignment(BookingRequest\Consignment $consignment)
    {
        return $this->addData('consignments', $consignment);
    }

    public function validate(): void
    {
        if (! $this->getData('consignments')) {
            throw new ContractValidationException('BookingRequest requires at least one of "consignments".');
        }
    }
}
