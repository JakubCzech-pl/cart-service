<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Repository\CartRepository;

class AddAddressService implements AddAddressServiceInterface
{
    public function __construct(private CartRepository $cartRepository) {}

    public function execute(AddAddressCandidate $addAddressCandidate): void
    {
        $cart = $addAddressCandidate->getCart();
        $cart->addAddress($addAddressCandidate->getAddress());

        $this->cartRepository->save($cart);
    }
}
