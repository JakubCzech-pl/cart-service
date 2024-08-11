<?php

declare(strict_types=1);

namespace App\Messenger\Address;

class RegionDto
{
    public function __construct(
        public readonly string $regionName,
        public readonly string $postCode,
        public readonly string $countryCode,
        public readonly string $city,
    ) {}
}
