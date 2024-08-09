<?php

declare(strict_types=1);

namespace App\Model\Address;

class Person implements PersonInterface
{
    public function __construct(
        protected string $firstName,
        protected string $lastName,
        protected string $phoneNumber
    ) {}

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}
