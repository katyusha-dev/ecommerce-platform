<?php

namespace Trafficfox\Bring\API\Contract\EasyReturn;

use DateTime;
use Trafficfox\Bring\API\Contract\ContractValidationException;
use Trafficfox\Bring\API\Contract\EasyReturn\LabelRequest as Contract;

class LabelRequest extends \Trafficfox\Bring\API\Contract\ApiEntity
{
    protected $_data = [
        'CustomerId' => null,
        'OrderDate' => null,
        'Sender' => null,
        'Recipient' => null,
        'Shipment' => null,
    ];

    public function setSender(Contract\Sender $sender)
    {
        return $this->setData('Sender', $sender);
    }

    public function setOrderDate(DateTime $dateTime)
    {
        return $this->setData('OrderDate', $dateTime->format('Y-m-d\TH:i:s'));
    }

    public function setCustomerId($customerId)
    {
        return $this->setData('CustomerId', $customerId);
    }

    public function setRecipient(Contract\Recipient $recipient)
    {
        return $this->setData('Recipient', $recipient);
    }

    public function setShipment(Contract\Shipment $shipment)
    {
        return $this->setData('Shipment', $shipment);
    }

    public function validate(): void
    {
        if (! $this->getData('CustomerId')) {
            throw new ContractValidationException('LabelRequest requires "CustomerId" attribute to be set.');
        }

        if (! $this->getData('Sender')) {
            throw new ContractValidationException('LabelRequest requires "Sender" attribute to be set.');
        }

        if (! $this->getData('OrderDate')) {
            throw new ContractValidationException('LabelRequest requires "OrderDate" attribute to be set.');
        }

        if (! $this->getData('Recipient')) {
            throw new ContractValidationException('LabelRequest requires "Recipient" attribute to be set.');
        }

        if (! $this->getData('Shipment')) {
            throw new ContractValidationException('LabelRequest requires "Shipment" attribute to be set.');
        }
    }
}
