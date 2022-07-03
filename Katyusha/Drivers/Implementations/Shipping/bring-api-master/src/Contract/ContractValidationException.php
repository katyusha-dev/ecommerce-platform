<?php

namespace Trafficfox\Bring\API\Contract;

use Exception;

class ContractValidationException extends Exception
{
    protected $_fields = [];

    public function addField($field): void
    {
        $this->_fields[] = $field;
    }

    public function getFields()
    {
        return $this->_fields;
    }
}
