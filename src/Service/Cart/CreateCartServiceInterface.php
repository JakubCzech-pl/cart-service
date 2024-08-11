<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Model\Cart\CartInterface;

interface CreateCartServiceInterface
{
    public function execute(CartCandidate $cartCandidate): CartInterface;
}