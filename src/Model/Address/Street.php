<?php

declare(strict_types=1);

namespace App\Model\Address;

class Street implements StreetInterface
{
    public function __construct(
        protected string $streetName,
        protected string $streetNumber,
        protected string $streetAddition
    ) {}

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function getStreetNumber(): string
    {
        return $this->streetNumber;
    }

    public function getStreetAddition(): string
    {
        return $this->streetAddition;
    }
}
