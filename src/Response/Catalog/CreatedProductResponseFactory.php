<?php

declare(strict_types=1);

namespace App\Response\Catalog;

use App\Model\Catalog\ProductInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreatedProductResponseFactory implements ProductResponseFactoryInterface
{
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

        return new JsonResponse([
            self::MESSAGE_KEY => 'Product created successfully',
            'productId' => $this->product->getId(),
        ]);
    }
}
