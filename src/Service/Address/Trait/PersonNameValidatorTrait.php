<?php

declare(strict_types=1);

namespace App\Service\Address\Trait;

use App\Exception\Address\Person\EmptyPersonNameException;
use App\Exception\Address\Person\PersonNameContainDigitsException;

trait PersonNameValidatorTrait
{
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
        return \preg_match('/\d/', $name) !== 0;
    }
}