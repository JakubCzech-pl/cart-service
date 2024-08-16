<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Address;

use App\Entity\Person;
use App\Exception\Address\Person\EmptyPersonNameException;
use App\Exception\Address\Person\InvalidPhoneNumberFormatException;
use App\Exception\Address\Person\PersonNameContainDigitsException;
use App\Service\Address\PersonCandidate;
use PHPUnit\Framework\TestCase;

class PersonCandidateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCanBeCreatedWithValidPersonDetails(): void
    {
        $personCandidate = new PersonCandidate(
            'John',
            'Doe',
            '+48123456789'
        );

        self::assertInstanceOf(PersonCandidate::class, $personCandidate);
        self::assertInstanceOf(Person::class, $personCandidate->toPerson());
    }

    public function testCannotBeCreatedWithEmptyFirstName(): void
    {
        $this->expectException(EmptyPersonNameException::class);

        new PersonCandidate(
            '',
            'Doe',
            '+48123456789'
        );
    }

    public function testCannotBeCreatedWithFirstNameWithNumbers(): void
    {
        $this->expectException(PersonNameContainDigitsException::class);

        new PersonCandidate(
            'J0hn',
            'Doe',
            '+48123456789'
        );
    }

    public function testCannotBeCreatedWithEmptyLastName(): void
    {
        $this->expectException(EmptyPersonNameException::class);

        new PersonCandidate(
            'John',
            '',
            '+48123456789'
        );
    }

    public function testCannotBeCreatedWithLastNameWithNumbers(): void
    {
        $this->expectException(PersonNameContainDigitsException::class);

        new PersonCandidate(
            'John',
            'D03',
            '+48123456789'
        );
    }

    public function testCannotBeCreatedWithEmptyPhoneNumber(): void
    {
        $this->expectException(InvalidPhoneNumberFormatException::class);

        new PersonCandidate(
            'John',
            'Doe',
            ''
        );
    }

    public function testCannotBeCreatedWithWrongPhoneNumberFormat(): void
    {
        $this->expectException(InvalidPhoneNumberFormatException::class);

        new PersonCandidate(
            'John',
            'Doe',
            '123 abc 456'
        );
    }
}