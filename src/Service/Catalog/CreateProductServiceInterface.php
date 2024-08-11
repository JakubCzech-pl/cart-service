<?php

declare(strict_types=1);

namespace App\Service\Catalog;

use App\Model\Catalog\ProductInterface;

interface CreateProductServiceInterface
{
    public function execute(ProductCandidate $productCandidate): ProductInterface;
}