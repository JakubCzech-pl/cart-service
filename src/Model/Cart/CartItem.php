<?php

declare(strict_types=1);

namespace App\Model\Cart;

use App\Model\Catalog\ProductInterface;

class CartItem implements CartItemInterface
{
    protected int $id;
    protected CartInterface $cart;
    protected ProductInterface $product;
    protected int $quantity;
    protected float $price;

    public function __construct(CartInterface $cart, ProductInterface $product, float $price,  int $quantity)
    {
        $this->cart = $cart;
        $this->product = $product;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCart(): CartInterface
    {
        return $this->cart;
    }

    public function getProductName(): string
    {
        return $this->product->getName();
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
