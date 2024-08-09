<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Model\Cart\CartItemInterface;

interface AddProductServiceInterface
{
    public function execute(CartItemCandidate $cartItemCandidate): CartItemInterface;
}