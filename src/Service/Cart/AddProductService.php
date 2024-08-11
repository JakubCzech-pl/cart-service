<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Model\Cart\CartItemInterface;
use App\Repository\CartItemRepository;
use App\Service\EntityFactoryInterface;

class AddProductService implements AddProductServiceInterface
{
    public function __construct(
        private EntityFactoryInterface $entityFactory,
        private CartItemRepository $cartItemRepository
    ) {}

    public function execute(CartItemCandidate $cartItemCandidate): CartItemInterface
    {
        $cartItem = $this->entityFactory->create($cartItemCandidate);

        $this->cartItemRepository->save($cartItem);

        return $cartItem;
    }
}
