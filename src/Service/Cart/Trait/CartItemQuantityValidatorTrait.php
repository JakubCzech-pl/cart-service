<?php

declare(strict_types=1);

namespace App\Service\Cart\Trait;

use App\Exception\Cart\EntityCandidate\NotPositiveProductQuantityException;

trait CartItemQuantityValidatorTrait
{
    /**
     * @throws NotPositiveProductQuantityException
     */
    private function validateQuantity(int $quantity): void
    {
        if ($quantity >= 1) {
            return;
        }

        throw new NotPositiveProductQuantityException();
    }
}