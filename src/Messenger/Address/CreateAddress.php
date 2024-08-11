<?php

declare(strict_types=1);

namespace App\Messenger\Address;

use App\Messenger\MessageInterface;

class CreateAddress implements MessageInterface
{
    public function __construct(
        public readonly PersonDto $person,
        public readonly RegionDto $region,
        public readonly StreetDto $street
    ) {}
}
