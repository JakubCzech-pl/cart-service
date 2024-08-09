<?php

declare(strict_types=1);

namespace App\Response\Cart;

use App\Model\Cart\CartInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreatedCartResponseFactory implements CartResponseFactoryInterface
{
    private ?CartInterface $cart = null;

    public function setCart(CartInterface $cart): void
    {
        $this->cart = $cart;
    }

    public function create(): JsonResponse
    {
        if (!$this->cart) {
            return new JsonResponse([], Response::HTTP_ACCEPTED);
        }

        return new JsonResponse([
            self::MESSAGE_KEY => 'Cart created successfully.',
            'cartId' => $this->cart->getId()
        ]);
    }
}
