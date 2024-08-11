<?php

declare(strict_types=1);

namespace App\Service\Cart;

interface AddAddressServiceInterface
{
    public function execute(AddAddressCandidate $addAddressCandidate): void;
}