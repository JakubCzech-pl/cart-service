<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Exception\Cart\EntityCandidate\NotPositiveProductQuantityException;
use App\Model\Cart\CartItemInterface;
use App\Service\Cart\Trait\CartItemQuantityValidatorTrait;

class UpdateCartItemQuantityCandidate
{
    use CartItemQuantityValidatorTrait;

    private int $cartItemId;
    private int $quantity;

    /**
     * @throws NotPositiveProductQuantityException
     */
    public function __construct(CartItemInterface $cartItem, int $quantity)
    {
        $this->validateQuantity($quantity);

        $this->cartItemId = $cartItem->getId();
        $this->quantity = $quantity;
    }

    public function getCartItemId(): int
    {
        return $this->cartItemId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
