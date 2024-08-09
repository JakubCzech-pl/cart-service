<?php

declare(strict_types=1);

namespace App\Service\Address\Trait;

use App\Exception\Address\Person\InvalidPhoneNumberFormatException;

trait PersonPhoneNumberValidatorTrait
{
    private const PHONE_NUMBER_REGEX = '/^\+(\d{1,3})\s?\d{1,4}(\s?\d{1,4}){1,5}$/';

    /**
     * @throws InvalidPhoneNumberFormatException
     */
    public function validatePhoneNumber(string $phone): void
    {
        if (\preg_match(self::PHONE_NUMBER_REGEX, $phone) !== 0) {
            return;
        }

        throw new InvalidPhoneNumberFormatException();
    }
}