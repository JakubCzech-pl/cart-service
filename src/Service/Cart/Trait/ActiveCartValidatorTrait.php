<?php

declare(strict_types=1);

namespace App\Service\Cart\Trait;

use App\Exception\Cart\EntityCandidate\InactiveCartException;
use App\Model\Cart\CartInterface;

trait ActiveCartValidatorTrait
{
    /**
     * @throws InactiveCartException
     */
    private function validateCart(CartInterface $cart): void
    {
        if ($cart->isActive()) {
            return;
        }

        throw new InactiveCartException();
    }
}