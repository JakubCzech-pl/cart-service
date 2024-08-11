<?php

declare(strict_types=1);

namespace App\Service\Catalog\Trait;

use App\Exception\Catalog\EntityCandidate\NegativeProductPriceException;

trait ProductPriceValidatorTrait
{
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