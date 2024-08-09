<?php

declare(strict_types=1);

namespace App\Model\Cart;

use App\Model\EntityInterface;

interface CartItemInterface extends EntityInterface
{
    public function getCart(): CartInterface;
    public function getProductName(): string;
    public function getQuantity(): int;
    public function getPrice(): float;
}