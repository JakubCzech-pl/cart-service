<?php

declare(strict_types=1);

namespace App\Service\Address\Trait;

use App\Exception\Address\Person\EmptyPersonNameException;
use App\Exception\Address\Person\PersonNameContainDigitsException;

trait PersonNameValidatorTrait
{
    private const DIGITS_REGEX = '/\d/';

    /**
     * @throws EmptyPersonNameException|PersonNameContainDigitsException
     */
    private function validateName(string $name): void
    {
        if (empty($name)) {
            throw new EmptyPersonNameException();
        }

        if ($this->hasNameDigits($name)) {
            throw new PersonNameContainDigitsException();
        }
    }

    private function hasNameDigits(string $name): bool
    {
        return \preg_match(self::DIGITS_REGEX, $name) !== 0;
    }
}