<?php

declare(strict_types=1);

namespace App\Service\Cart;

interface UpdateCartItemQuantityServiceInterface
{
    public function execute(UpdateCartItemQuantityCandidate $updateCartItemQuantityCandidate): void;
}