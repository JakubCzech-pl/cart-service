<?php

declare(strict_types=1);

namespace App\Service\Catalog;

use App\Model\ProductInterface;

interface CreateProductServiceInterface
{
    public function execute(string $name, float $price, bool $isAvailable): ProductInterface;
}