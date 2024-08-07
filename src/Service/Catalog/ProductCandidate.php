<?php

declare(strict_types=1);

namespace App\Service\Catalog;

use App\Entity\Product;
use App\Exception\EntityCandidate\Catalog\InvalidProductNameLengthException;
use App\Exception\EntityCandidate\Catalog\NegativeProductPriceException;
use App\Exception\EntityCandidate\EntityCandidateArgumentException;
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
     * @throws InvalidProductNameLengthException
     */
    private function validateName(string $name): void
    {
        $length = \mb_strlen($name);
        if ($this->isNameLengthValid($length)) {
            return;
        }

        throw new InvalidProductNameLengthException(
            \sprintf(
                'Name should have at least %s and max %s characters',
                self::MIN_PRODUCT_NAME_LENGTH,
                self::MAX_PRODUCT_NAME_LENGTH
            )
        );
    }

    private function isNameLengthValid(int $nameLength): bool
    {
        return $nameLength >= self::MIN_PRODUCT_NAME_LENGTH &&
            $nameLength <= self::MAX_PRODUCT_NAME_LENGTH;
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
