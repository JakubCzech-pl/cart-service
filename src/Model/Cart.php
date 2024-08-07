<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Contracts\Cache\ItemInterface;

class Cart implements CartInterface
{
    protected int $id;
    protected Collection $items;

    public function __construct(CartItemInterface ...$items)
    {
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

    public function addItem(ItemInterface $item): void
    {
        $this->items->add($item);
    }

    public function removeItem(ItemInterface $item): void
    {
        $this->items->removeElement($item);
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
}
