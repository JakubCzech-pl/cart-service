<?php

declare(strict_types=1);

namespace App\Service\Catalog;

use App\Exception\Catalog\CouldNotCreateProductException;
use App\Exception\Catalog\EntityCandidate\NegativeProductPriceException;
use App\Exception\Catalog\EntityCandidate\ProductNameTooLongException;
use App\Exception\Catalog\EntityCandidate\ProductNameTooShortException;
use App\Model\ProductInterface;
use App\Repository\ProductRepository;
use App\Service\EntityFactoryInterface;

class CreateProductService implements CreateProductServiceInterface
{
    public function __construct(
        private EntityFactoryInterface $entityFactory,
        private ProductRepository $productRepository
    ) {}

    /**
     * @throws CouldNotCreateProductException
     */
    public function execute(string $name, float $price, bool $isAvailable): ProductInterface
    {
        $product = $this->entityFactory->create(
            $this->createCandidate($name, $price, $isAvailable)
        );

        $this->productRepository->save($product);

        return $product;
    }

    /**
     * @throws CouldNotCreateProductException
     */
    private function createCandidate(string $name, float $price, bool $isAvailable): ProductCandidate
    {
        try {
            return new ProductCandidate(
                $name,
                $price,
                $isAvailable
            );
        } catch (ProductNameTooShortException|ProductNameTooLongException $exception) {
            throw new CouldNotCreateProductException($exception->getMessage());
        } catch (NegativeProductPriceException) {
            throw new CouldNotCreateProductException('Product price cannot be negative number');
        }
    }
}
