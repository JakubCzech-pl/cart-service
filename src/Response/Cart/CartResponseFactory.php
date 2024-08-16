<?php

declare(strict_types=1);

namespace App\Response\Cart;

use App\Model\Cart\CartInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CartResponseFactory implements CartResponseFactoryInterface
{
    private ?CartInterface $cart = null;

    public function __construct(private NormalizerInterface $normalizer) {}

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
        try {
            $cartNormalized = $this->normalizer->normalize($this->cart);
            $cartNormalized['addressId'] = $this->cart->getAddress()?->getId();

            return $cartNormalized;
        } catch (ExceptionInterface) {
            return [
                self::MESSAGE_KEY => 'Cannot Process this Cart at the moment.',
            ];
        }
    }
}
