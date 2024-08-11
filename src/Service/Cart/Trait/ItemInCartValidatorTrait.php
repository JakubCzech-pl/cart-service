<?php

declare(strict_types=1);

namespace App\Service\Cart\Trait;

use App\Exception\Cart\CartItemNotInCartException;
use App\Model\Cart\CartInterface;
use App\Model\Cart\CartItemInterface;

trait ItemInCartValidatorTrait
{
    /**
     * @throws CartItemNotInCartException
     */
    private function checkIsItemInCart(CartItemInterface $cartItem, CartInterface $cart): void
    {
        if ($cart->hasItem($cartItem) && $cartItem->getCart()->getId() === $cart->getId()) {
            return;
        }

        throw new CartItemNotInCartException();
    }
}