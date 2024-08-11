<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Entity\CartItem;
use App\Exception\Cart\EntityCandidate\InactiveCartException;
use App\Exception\Cart\EntityCandidate\NotPositiveProductQuantityException;
use App\Exception\Cart\EntityCandidate\ProductNotAvailableException;
use App\Exception\EntityCandidateArgumentException;
use App\Model\Cart\CartInterface;
use App\Model\Catalog\ProductInterface;
use App\Model\EntityInterface;
use App\Service\Cart\Trait\ActiveCartValidatorTrait;
use App\Service\Cart\Trait\CartItemQuantityValidatorTrait;
use App\Service\Cart\Trait\ProductAvailabilityValidatorTrait;
use App\Service\EntityCandidateInterface;

class CartItemCandidate implements EntityCandidateInterface
{
    use CartItemQuantityValidatorTrait;
    use ProductAvailabilityValidatorTrait;
    use ActiveCartValidatorTrait;

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
}
