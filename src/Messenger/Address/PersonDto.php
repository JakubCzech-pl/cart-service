<?php

declare(strict_types=1);

namespace App\Messenger\Address;

class PersonDto
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $phoneNumber
    ) {}
}
