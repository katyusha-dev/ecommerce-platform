<?php

namespace Trafficfox\Bring\API\Client;

use Exception;

class BookingClientException extends Exception
{
    private $_errors = [];

    public function setErrors(array $errors): void
    {
        $this->_errors = $errors;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function getDetaildMessage()
    {
        $message = parent::getMessage();
        $codes = [];
        foreach ($this->_errors as $error) {
            $codes[] = $error['code'];
        }

        if ($codes) {
            $message .= " \nError codes:".implode(', ', $codes);
        }

        return $message;
    }
}
