<?php

declare(strict_types=1);

namespace App\Messenger\Cart;

use App\Messenger\MessageInterface;

class AddAddress implements MessageInterface
{
    public function __construct(
        public readonly int $cartId,
        public readonly int $addressId
    ) {}
}
