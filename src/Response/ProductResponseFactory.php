<?php

declare(strict_types=1);

namespace App\Response;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ProductResponseFactory implements ProductResponseFactoryInterface
{
    public function __construct(private SerializerInterface $serializer) {}

    private Product $product;

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function create(): JsonResponse
    {
        return new JsonResponse(
            $this->normalizeProduct(),
            Response::HTTP_OK
        );
    }

    private function normalizeProduct(): array
    {
        return $this->serializer->normalize($this->product);
    }
}
