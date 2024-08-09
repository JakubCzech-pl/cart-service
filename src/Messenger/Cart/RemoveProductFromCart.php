<?php

declare(strict_types=1);

namespace App\Messenger\Cart;

use App\Messenger\MessageInterface;

class RemoveProductFromCart implements MessageInterface
{
    public function __construct(
        public readonly int $cartItemId,
        public readonly int $cartId
    ) {}
}
