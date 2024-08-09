<?php

declare(strict_types=1);

namespace App\Model\Address;

class Street implements StreetInterface
{
    protected string $street;

    public function __construct(
        private string $streetName,
        private string $streetNumber,
        private string $streetAddition
    ) {
        $this->street = \sprintf(
            '%s %s %s',
            $streetName,
            $streetNumber,
            $streetAddition
        );
    }

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
