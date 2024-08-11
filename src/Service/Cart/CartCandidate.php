<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Model\Cart\CartItemInterface;
use App\Model\EntityInterface;
use App\Service\EntityCandidateInterface;

class CartCandidate implements EntityCandidateInterface
{
    /**
     * @var CartItemInterface[]
     */
    private array $cartItems;

    public function __construct(CartItemInterface ...$cartItems)
    {
        $this->cartItems = $cartItems;
    }

    public function toEntity(): EntityInterface
    {
        return new Cart(null, true, ...$this->cartItems);
    }
}
