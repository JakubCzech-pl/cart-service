<?php

declare(strict_types=1);

namespace App\Service\Address\Trait;

use App\Exception\Address\Region\EmptyCityException;

trait RegionCityValidatorTrait
{
    /**
     * @throws EmptyCityException
     */
    private function validateCity(string $city): void
    {
        if (!empty($city)) {
            return;
        }

        throw new EmptyCityException();
    }
}