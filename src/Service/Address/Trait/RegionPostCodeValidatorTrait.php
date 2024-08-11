<?php

declare(strict_types=1);

namespace App\Service\Address\Trait;

use App\Exception\Address\Region\EmptyPostCodeException;

trait RegionPostCodeValidatorTrait
{
    /**
     * @throws EmptyPostCodeException
     */
    private function validatePostCode(string $postCode): void
    {
        if (!empty($postCode)) {
            return;
        }

        throw new EmptyPostCodeException();
    }
}