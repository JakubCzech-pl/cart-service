<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Repository\CartItemRepository;

class UpdateCartItemQuantityService implements UpdateCartItemQuantityServiceInterface
{
    public function __construct(private CartItemRepository $cartItemRepository) {}

    public function execute(UpdateCartItemQuantityCandidate $updateCartItemQuantityCandidate): void
    {
        $this->cartItemRepository->updateCartItemQuantity(
            $updateCartItemQuantityCandidate->getCartItemId(),
            $updateCartItemQuantityCandidate->getQuantity()
        );
    }
}
