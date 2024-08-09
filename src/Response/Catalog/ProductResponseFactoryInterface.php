<?php

declare(strict_types=1);

namespace App\Response\Catalog;

use App\Model\Catalog\ProductInterface;
use App\Response\ResponseFactoryInterface;

interface ProductResponseFactoryInterface extends ResponseFactoryInterface
{
    public function setProduct(ProductInterface $product): void;
}