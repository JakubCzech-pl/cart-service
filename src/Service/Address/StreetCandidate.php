<?php

declare(strict_types=1);

namespace App\Service\Address;

use App\Entity\Street;
use App\Exception\Address\Street\EmptyStreetNameException;
use App\Service\Address\Trait\StreetNameValidatorTrait;

class StreetCandidate
{
    use StreetNameValidatorTrait;

    private string $streetName;
    private string $streetNumber;
    private string $streetAddition;

    /**
     * @throws EmptyStreetNameException
     */
    public function __construct(string $streetName, string $streetNumber, string $streetAddition)
    {
        $this->validateStreetName($streetName);

        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->streetAddition = $streetAddition;
    }

    public function toStreet(): Street
    {
        return new Street(
            $this->streetName,
            $this->streetNumber,
            $this->streetAddition
        );
    }
}
