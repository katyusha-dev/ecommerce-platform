<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Payment;

/**
 * Class CustomerInfo.
 */
class UserDetails
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $bankIdVerified;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $dateOfBirth;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $email;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $firstName;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $lastName;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $mobileNumber;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $ssn;

    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected string $userId;

    public function getBankIdVerified(): string
    {
        return $this->bankIdVerified;
    }

    public function getDateOfBirth(): string
    {
        return $this->dateOfBirth;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Gets mobileNumber value.
     */
    public function getMobileNumber(): string
    {
        return $this->mobileNumber;
    }

    public function getSsn(): string
    {
        return $this->ssn;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
