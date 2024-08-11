<?php

declare(strict_types=1);

namespace App\Service\Address\Trait;

use App\Exception\Address\Street\EmptyStreetNameException;

trait StreetNameValidatorTrait
{
    /**
     * @throws EmptyStreetNameException
     */
    private function validateStreetName(string $streetName): void
    {
        if (!empty($streetName)) {
            return;
        }

        throw new EmptyStreetNameException();
    }
}