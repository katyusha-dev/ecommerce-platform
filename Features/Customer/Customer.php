<?php

namespace Features\Customer;

use Features\Customer\Models\CustomerModel;

class Customer extends CustomerModel {
    public static function loadFromRequest(): ?static {
        $session = CustomerSession::loadFromRequest();

        if (!$session) {
            return null;
        }

        return $session->customer;
    }

    public static function getOrCreate(int $mobileNumber): static {
        if ($existing = static::where('mobile_number', $mobileNumber)->first()) {
            return $existing;
        }

        $customer = new static();
        $customer->setMobileNumber($mobileNumber);

        return $customer;
    }

    public static function getCustomerByCredentials(int $mobileNumber, int $password): ?static {
        if ($customer = static::where('password', $password)->where('mobile_number', $mobileNumber)->first()) {
            return $customer;
        }

        if ($customer = static::newCustomer($mobileNumber, $password)) {
            return $customer;
        }

        return null;
    }

    public static function newCustomer(int $mobileNumber, int $password): static {
        return static::make()->setMobileNumber($mobileNumber)->setPassword($password)->saveAndReturnModel();
    }
}
