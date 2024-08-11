<?php

declare(strict_types=1);

namespace App\Messenger\Catalog;

use App\Messenger\MessageInterface;

class CreateProduct implements MessageInterface
{
    public function __construct(
        public readonly string $name,
        public readonly float $price,
        public readonly bool $isAvailable
    ) {}
}
