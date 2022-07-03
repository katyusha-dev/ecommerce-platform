<?php

namespace Features\Customer\Eloquent\SettersAndGetters;

use Features\Customer\Models\CustomerModel;

trait CustomerModelSetterAndGetters {
    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(?string $address): CustomerModel {
        $this->address = $address;

        return $this;
    }

    public function getAddress2(): ?string {
        return $this->address_2;
    }

    public function setAddress2(?string $address_2): CustomerModel {
        $this->address_2 = $address_2;

        return $this;
    }

    public function getZip(): ?string {
        return $this->zip;
    }

    public function setZip(?string $zip): CustomerModel {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function setCity(?string $city): CustomerModel {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string {
        return $this->country;
    }

    public function setCountry(?string $country): CustomerModel {
        $this->country = $country;

        return $this;
    }

    public function getFirstRegistrationShop(): ?string {
        return $this->first_registration_shop;
    }

    public function setFirstRegistrationShop(?string $first_registration_shop): CustomerModel {
        $this->first_registration_shop = $first_registration_shop;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): CustomerModel {
        $this->email = $email;

        return $this;
    }

    public function getGender(): ?string {
        return $this->gender;
    }

    public function setGender(?string $gender): CustomerModel {
        $this->gender = $gender;

        return $this;
    }

    public function getNameFirst(): ?string {
        return $this->name_first;
    }

    public function setNameFirst(?string $name_first): CustomerModel {
        $this->name_first = $name_first;

        return $this;
    }

    public function getNameLast(): ?string {
        return $this->name_last;
    }

    public function setNameLast(?string $name_last): CustomerModel {
        $this->name_last = $name_last;

        return $this;
    }

    public function getMobileNumber(): int {
        return $this->mobile_number;
    }

    public function setMobileNumber(int $mobile_number): CustomerModel {
        $this->mobile_number = $mobile_number;

        return $this;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(?int $password): CustomerModel {
        $this->password = $password;

        return $this;
    }
}
