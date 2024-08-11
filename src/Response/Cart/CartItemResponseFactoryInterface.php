<?php

declare(strict_types=1);

namespace App\Response\Cart;

use App\Model\Cart\CartItemInterface;
use App\Response\ResponseFactoryInterface;

interface CartItemResponseFactoryInterface extends ResponseFactoryInterface
{
    public function setCartItem(CartItemInterface $cartItem): void;
}