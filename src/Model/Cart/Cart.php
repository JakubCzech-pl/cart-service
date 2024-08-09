<?php

declare(strict_types=1);

namespace App\Model\Cart;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Cart implements CartInterface
{
    protected int $id;
    protected Collection $items;
    protected bool $isActive;

    public function __construct(bool $isActive, CartItemInterface ...$items)
    {
        $this->isActive = $isActive;
        $this->items = new ArrayCollection($items);
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getItems(): array
    {
        return $this->items->getValues();
    }

    public function addItem(CartItemInterface $item): void
    {
        $this->items->add($item);
    }

    public function removeItem(CartItemInterface $item): void
    {
        $this->items->removeElement($item);
    }

    public function hasItem(CartItemInterface $item): bool
    {
        return $this->items->contains($item);
    }

    public function getTotalPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalPrice += $item->getPrice();
        }

        return $totalPrice;
    }

    public function getTotalQuantity(): int
    {
        $qty = 0;
        foreach ($this->items as $item) {
            $qty += $item->getQuantity();
        }

        return $qty;
    }

    public function isActive(): bool
    {
       return $this->isActive;
    }
}
