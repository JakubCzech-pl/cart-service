<?php

declare(strict_types=1);

namespace App\Service\Address\Trait;

use App\Exception\Address\Region\CountryCodeBeyondStandardsException;

trait RegionCountryCodeValidatorTrait
{
    /**
     * @throws CountryCodeBeyondStandardsException
     */
    private function validateCountryCode(string $countryCode): void
    {
        $codeLength = \strlen($countryCode);
        if ($codeLength === 2 || $codeLength === 3) {
            return;
        }

        throw new CountryCodeBeyondStandardsException();
    }
}