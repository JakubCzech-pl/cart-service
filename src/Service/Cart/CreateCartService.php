<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Model\Cart\CartInterface;
use App\Repository\CartRepository;
use App\Service\EntityFactoryInterface;

class CreateCartService implements CreateCartServiceInterface
{
    public function __construct(
        private EntityFactoryInterface $entityFactory,
        private CartRepository $cartRepository
    ) {}

    public function execute(CartCandidate $cartCandidate): CartInterface
    {
        $cart = $this->entityFactory->create($cartCandidate);

        $this->cartRepository->save($cart);

        return $cart;
    }
}
