<?php

declare(strict_types=1);

namespace App\Messenger\Address;

class StreetDto
{
    public function __construct(
        public readonly string $streetName,
        public readonly string $streetNumber,
        public readonly string $streetAddition = ''
    ) {}
}
