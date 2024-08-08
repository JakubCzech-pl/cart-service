<?php

declare(strict_types=1);

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Response\ProductResponseFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'catalog/product/{product}', name: 'show-product', methods: 'GET')]
class ShowProductsController extends AbstractController
{
    public function __construct(private ProductResponseFactoryInterface $productResponseFactory) {}

    public function __invoke(Product $product): JsonResponse
    {
        $this->productResponseFactory->setProduct($product);

        return $this->productResponseFactory->create();
    }
}
