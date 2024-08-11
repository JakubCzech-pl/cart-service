<?php

declare(strict_types=1);

namespace App\Model\Address;

class Address implements AddressInterface
{
    protected int $id;

    public function __construct(
        protected PersonInterface $person,
        protected RegionInterface $region,
        protected StreetInterface $street
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->person->getFirstName();
    }

    public function getLastName(): string
    {
        return $this->person->getLastName();
    }

    public function getPhoneNumber(): string
    {
        return $this->person->getPhoneNumber();
    }

    public function getStreetName(): string
    {
        return $this->street->getStreetName();
    }

    public function getStreetNumber(): string
    {
        return $this->street->getStreetNumber();
    }

    public function getStreetAddition(): string
    {
        return $this->street->getStreetAddition();
    }

    public function getRegionName(): string
    {
        return $this->region->getRegionName();
    }

    public function getPostCode(): string
    {
        return $this->region->getPostCode();
    }

    public function getCity(): string
    {
        return $this->region->getCity();
    }

    public function getCountryCode(): string
    {
        return $this->region->getCountryCode();
    }
}
