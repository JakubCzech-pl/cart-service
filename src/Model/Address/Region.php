<?php

declare(strict_types=1);

namespace App\Model\Address;

class Region implements RegionInterface
{
    public function __construct(
        protected string $regionName,
        protected string $postcode,
        protected string $countryCode,
        protected string $city
    ) {}

    public function getRegionName(): string
    {
        return $this->regionName;
    }

    public function getPostCode(): string
    {
        return $this->postcode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }
}
