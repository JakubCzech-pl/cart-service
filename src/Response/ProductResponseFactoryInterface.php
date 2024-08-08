<?php

declare(strict_types=1);

namespace App\Response;

use App\Entity\Product;

interface ProductResponseFactoryInterface extends ResponseFactoryInterface
{
    public function setProduct(Product $product): void;
}