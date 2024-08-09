<?php

declare(strict_types=1);

namespace App\Service\Catalog;

use App\Model\Catalog\ProductInterface;
use App\Repository\ProductRepository;
use App\Service\EntityFactoryInterface;

class CreateProductService implements CreateProductServiceInterface
{
    public function __construct(
        private EntityFactoryInterface $entityFactory,
        private ProductRepository $productRepository
    ) {}

    public function execute(ProductCandidate $productCandidate): ProductInterface
    {
        $product = $this->entityFactory->create($productCandidate);

        $this->productRepository->save($product);

        return $product;
    }
}
