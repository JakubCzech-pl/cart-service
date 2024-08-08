<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Model\CartInterface;

interface CreateCartServiceInterface
{
    public function execute(): CartInterface;
}