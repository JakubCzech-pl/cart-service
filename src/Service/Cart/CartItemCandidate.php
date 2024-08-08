<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Entity\CartItem;
use App\Exception\Cart\EntityCandidate\InactiveCartException;
use App\Exception\Cart\EntityCandidate\NotPositiveProductQuantityException;
use App\Exception\Cart\EntityCandidate\ProductNotAvailableException;
use App\Exception\EntityCandidateArgumentException;
use App\Model\CartInterface;
use App\Model\EntityInterface;
use App\Model\ProductInterface;
use App\Service\EntityCandidateInterface;

class CartItemCandidate implements EntityCandidateInterface
{
    private CartInterface $cart;
    private ProductInterface $product;
    private float $price;
    private int $quantity;

    /**
     * @throws EntityCandidateArgumentException
     */
    public function __construct(
        CartInterface $cart,
        ProductInterface $product,
        float $price,
        int $quantity
    ) {
        $this->validateCart($cart);
        $this->validateProduct($product);
        $this->validateQuantity($quantity);

        $this->cart = $cart;
        $this->product = $product;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function toEntity(): EntityInterface
    {
        return new CartItem(
            $this->cart,
            $this->product,
            $this->price,
            $this->quantity
        );
    }

    /**
     * @throws InactiveCartException
     */
    private function validateCart(CartInterface $cart): void
    {
        if ($cart->isActive()) {
            return;
        }

        throw new InactiveCartException();
    }

    /**
     * @throws ProductNotAvailableException
     */
    private function validateProduct(ProductInterface $product): void
    {
        if ($product->isAvailable()) {
            return;
        }

        throw new ProductNotAvailableException();
    }

    /**
     * @throws NotPositiveProductQuantityException
     */
    private function validateQuantity(int $quantity): void
    {
        if ($quantity >= 1) {
            return;
        }

        throw new NotPositiveProductQuantityException();
    }
}
