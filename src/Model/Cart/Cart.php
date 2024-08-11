<?php

declare(strict_types=1);

namespace App\Model\Cart;

use App\Model\Address\AddressInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Cart implements CartInterface
{
    protected int $id;
    protected Collection $items;

    public function __construct(
        protected ?AddressInterface $address,
        protected bool $isActive,
        CartItemInterface ...$items
    ) {
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
            $totalPrice += $item->getPrice() * $item->getQuantity();
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

    public function addAddress(AddressInterface $address): void
    {
        $this->address = $address;
    }

    public function getAddress(): ?AddressInterface
    {
        return $this->address;
    }
}
