<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Contracts\Cache\ItemInterface;

interface CartInterface extends EntityInterface
{
    /**
     * @return CartItemInterface[]
     */
    public function getItems(): array;
    public function addItem(ItemInterface $item): void;
    public function removeItem(ItemInterface $item): void;
    public function getTotalPrice(): float;
    public function getTotalQuantity(): int;
}