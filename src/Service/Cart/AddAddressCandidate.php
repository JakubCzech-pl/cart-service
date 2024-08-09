<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Model\Address\AddressInterface;
use App\Model\Cart\CartInterface;

class AddAddressCandidate
{
    public function __construct(
        private CartInterface $cart,
        private AddressInterface $address
    ) {}

    public function getCart(): CartInterface
    {
        return $this->cart;
    }

    public function getAddress(): AddressInterface
    {
        return $this->address;
    }
}
