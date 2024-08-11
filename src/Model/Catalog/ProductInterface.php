<?php

declare(strict_types=1);

namespace App\Model\Catalog;

use App\Model\EntityInterface;

interface ProductInterface extends EntityInterface
{
    public function getName(): string;
    public function getPrice(): float;
    public function isAvailable(): bool;
}