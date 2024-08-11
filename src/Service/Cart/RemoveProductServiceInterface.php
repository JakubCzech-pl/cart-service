<?php

declare(strict_types=1);

namespace App\Service\Cart;


interface RemoveProductServiceInterface
{
    public function execute(RemovalCartItemCandidate $removalCartItemCandidate): void;
}