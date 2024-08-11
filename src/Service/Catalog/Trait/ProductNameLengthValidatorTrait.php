<?php

declare(strict_types=1);

namespace App\Service\Catalog\Trait;

use App\Exception\Catalog\EntityCandidate\ProductNameTooLongException;
use App\Exception\Catalog\EntityCandidate\ProductNameTooShortException;

trait ProductNameLengthValidatorTrait
{
    private const MIN_PRODUCT_NAME_LENGTH = 4;
    private const MAX_PRODUCT_NAME_LENGTH = 128;

    /**
     * @throws ProductNameTooShortException|ProductNameTooLongException
     */
    private function validateProductNameLength(string $productName): void
    {
        $nameLength = \mb_strlen($productName);
        $this->checkIsTooShort($nameLength);
        $this->checkIsTooLong($nameLength);
    }

    /**
     * @throws ProductNameTooShortException
     */
    private function checkIsTooShort(int $nameLength): void
    {
        if ($nameLength >= self::MIN_PRODUCT_NAME_LENGTH) {
            return;
        }

        throw new ProductNameTooShortException(
            \sprintf(
                'Product name should be at least %s characters long',
                self::MIN_PRODUCT_NAME_LENGTH
            )
        );
    }

    /**
     * @throws ProductNameTooLongException
     */
    private function checkIsTooLong(int $nameLength): void
    {
        if ($nameLength <= self::MAX_PRODUCT_NAME_LENGTH) {
            return;
        }

        throw new ProductNameTooLongException(
            \sprintf(
                'Product name should be less than %s characters long',
                self::MAX_PRODUCT_NAME_LENGTH
            )
        );
    }
}