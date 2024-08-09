<?php

declare(strict_types=1);

namespace App\Response\Cart;

use App\Model\Cart\CartInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CartResponseFactory implements CartResponseFactoryInterface
{
    private ?CartInterface $cart = null;

    public function __construct(private SerializerInterface $serializer) {}

    public function setCart(CartInterface $cart): void
    {
        $this->cart = $cart;
    }

    public function create(): JsonResponse
    {
        if (!$this->cart) {
            return new JsonResponse([], Response::HTTP_ACCEPTED);
        }

        return new JsonResponse(
            $this->normalizeCart()
        );
    }

    private function normalizeCart(): array
    {
        return $this->serializer->normalize($this->cart);
    }
}
