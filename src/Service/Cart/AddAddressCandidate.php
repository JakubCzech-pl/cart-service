<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Exception\Cart\EntityCandidate\InactiveCartException;
use App\Model\Address\AddressInterface;
use App\Model\Cart\CartInterface;
use App\Service\Cart\Trait\ActiveCartValidatorTrait;

class AddAddressCandidate
{
    use ActiveCartValidatorTrait;

    private CartInterface $cart;
    private AddressInterface $address;

    /**
     * @throws InactiveCartException
     */
    public function __construct(CartInterface $cart, AddressInterface $address)
    {
        $this->validateCart($cart);

        $this->cart = $cart;
        $this->address = $address;
    }

    public function getCart(): CartInterface
    {
        return $this->cart;
    }

    public function getAddress(): AddressInterface
    {
        return $this->address;
    }
}
