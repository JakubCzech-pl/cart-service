<?php

declare(strict_types=1);

namespace App\Service\Address;

use App\Entity\Person;
use App\Exception\Address\Person\InvalidPersonDetailsException;
use App\Service\Address\Trait\PersonNameValidatorTrait;
use App\Service\Address\Trait\PersonPhoneNumberValidatorTrait;

class PersonCandidate
{
    use PersonNameValidatorTrait;
    use PersonPhoneNumberValidatorTrait;

    private string $firstName;
    private string $lastName;
    private string $phoneNumber;

    /**
     * @throws InvalidPersonDetailsException
     */
    public function __construct(string $firstName, string $lastName, string $phoneNumber)
    {
        $this->validateName($firstName);
        $this->validateName($lastName);
        $this->validatePhoneNumber($phoneNumber);

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
    }

    public function toPerson(): Person
    {
        return new Person(
            $this->firstName,
            $this->lastName,
            $this->phoneNumber
        );
    }
}
