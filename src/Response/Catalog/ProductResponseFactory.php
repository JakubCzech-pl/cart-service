<?php

declare(strict_types=1);

namespace App\Response\Catalog;

use App\Model\Catalog\ProductInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProductResponseFactory implements ProductResponseFactoryInterface
{
    public function __construct(private NormalizerInterface $normalizer) {}

    private ?ProductInterface $product = null;

    public function setProduct(ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function create(): JsonResponse
    {
        if (!$this->product) {
            return new JsonResponse([], Response::HTTP_ACCEPTED);
        }

        return new JsonResponse(
            $this->normalizeProduct(),
            Response::HTTP_OK
        );
    }

    private function normalizeProduct(): array
    {
        return $this->normalizer->normalize($this->product);
    }
}
