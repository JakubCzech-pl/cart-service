<?php

declare(strict_types=1);

namespace App\Response\Cart;

use App\Model\Cart\CartInterface;
use App\Response\ResponseFactoryInterface;

interface CartResponseFactoryInterface extends ResponseFactoryInterface
{
    public function setCart(CartInterface $cart): void;
}