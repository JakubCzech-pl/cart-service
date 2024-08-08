<?php

declare(strict_types=1);

namespace App\Service\Catalog;

use App\Entity\Product;
use App\Exception\Catalog\EntityCandidate\NegativeProductPriceException;
use App\Exception\Catalog\EntityCandidate\ProductNameTooLongException;
use App\Exception\Catalog\EntityCandidate\ProductNameTooShortException;
use App\Exception\EntityCandidateArgumentException;
use App\Model\EntityInterface;
use App\Service\EntityCandidateInterface;

class ProductCandidate implements EntityCandidateInterface
{
    private const MIN_PRODUCT_NAME_LENGTH = 4;
    private const MAX_PRODUCT_NAME_LENGTH = 128;

    private string $name;
    private float $price;
    private bool $isAvailable;

    /**
     * @throws EntityCandidateArgumentException
     */
    public function __construct(string $name, float $price, bool $isAvailable)
    {
        $this->validateName($name);
        $this->validatePrice($price);

        $this->name = $name;
        $this->price = $price;
        $this->isAvailable = $isAvailable;
    }

    public function toEntity(): EntityInterface
    {
        return new Product(
            $this->name,
            $this->price,
            $this->isAvailable
        );
    }

    /**
     * @throws ProductNameTooShortException|ProductNameTooLongException
     */
    private function validateName(string $name): void
    {
        $this->validateProductNameLength(
            \mb_strlen($name)
        );
    }

    /**
     * @throws ProductNameTooShortException|ProductNameTooLongException
     */
    private function validateProductNameLength(int $nameLength): void
    {
        if ($nameLength < self::MIN_PRODUCT_NAME_LENGTH) {
            throw new ProductNameTooShortException(
                \sprintf(
                    'Product name should be at least %s characters long',
                    self::MIN_PRODUCT_NAME_LENGTH
                )
            );
        }

        if ($nameLength > self::MAX_PRODUCT_NAME_LENGTH) {
            throw new ProductNameTooLongException(
                \sprintf(
                    'Product name should be less than %s characters long',
                    self::MAX_PRODUCT_NAME_LENGTH
                )
            );
        }
    }

    /**
     * @throws NegativeProductPriceException
     */
    private function validatePrice(float $price): void
    {
        if ($price >= 0) {
            return;
        }

        throw new NegativeProductPriceException();
    }
}
