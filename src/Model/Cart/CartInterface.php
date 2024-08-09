<?php

declare(strict_types=1);

namespace App\Model\Cart;

use App\Model\Address\AddressInterface;
use App\Model\EntityInterface;

interface CartInterface extends EntityInterface
{
    /**
     * @return CartItemInterface[]
     */
    public function getItems(): array;
    public function addItem(CartItemInterface $item): void;
    public function removeItem(CartItemInterface $item): void;
    public function hasItem(CartItemInterface $item): bool;
    public function getTotalPrice(): float;
    public function getTotalQuantity(): int;
    public function isActive(): bool;
    public function addAddress(AddressInterface $address): void;
    public function getAddress(): ?AddressInterface;
}
