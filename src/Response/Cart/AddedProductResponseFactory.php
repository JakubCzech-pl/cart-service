<?php

declare(strict_types=1);

namespace App\Response\Cart;

use App\Model\Cart\CartItemInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AddedProductResponseFactory implements CartItemResponseFactoryInterface
{

    private ?CartItemInterface $cartItem = null;

    public function setCartItem(CartItemInterface $cartItem): void
    {
        $this->cartItem = $cartItem;
    }

    public function create(): JsonResponse
    {
        if (!$this->cartItem) {
            return new JsonResponse([], Response::HTTP_ACCEPTED);
        }

        return new JsonResponse([
            self::MESSAGE_KEY => 'Added product to cart',
            'itemId' => $this->cartItem->getId(),
            'productName' => $this->cartItem->getProductName(),
        ]);
    }
}
