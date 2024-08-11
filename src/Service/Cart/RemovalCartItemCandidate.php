<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Exception\Cart\CartItemNotInCartException;
use App\Model\Cart\CartInterface;
use App\Model\Cart\CartItemInterface;
use App\Model\EntityInterface;
use App\Service\Cart\Trait\ItemInCartValidatorTrait;
use App\Service\EntityCandidateInterface;

class RemovalCartItemCandidate implements EntityCandidateInterface
{
    use ItemInCartValidatorTrait;

    private CartItemInterface $cartItem;

    /**
     * @throws CartItemNotInCartException
     */
    public function __construct(CartItemInterface $cartItem, CartInterface $cart)
    {
        $this->checkIsItemInCart($cartItem, $cart);

        $this->cartItem = $cartItem;
    }

    public function toEntity(): EntityInterface
    {
        return $this->cartItem;
    }
}
