<?php

declare(strict_types=1);

namespace App\Service\Cart\Trait;

use App\Exception\Cart\EntityCandidate\ProductNotAvailableException;
use App\Model\Catalog\ProductInterface;

trait ProductAvailabilityValidatorTrait
{
    /**
     * @throws ProductNotAvailableException
     */
    private function validateProduct(ProductInterface $product): void
    {
        if ($product->isAvailable()) {
            return;
        }

        throw new ProductNotAvailableException();
    }
}