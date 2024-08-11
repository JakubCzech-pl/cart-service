<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Repository\CartItemRepository;

class RemoveProductService implements RemoveProductServiceInterface
{
    public function __construct(private CartItemRepository $cartItemRepository) {}

    public function execute(RemovalCartItemCandidate $removalCartItemCandidate): void
    {
        $this->cartItemRepository->delete(
            $removalCartItemCandidate->toEntity()
        );
    }
}
