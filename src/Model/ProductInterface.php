<?php

declare(strict_types=1);

namespace App\Model;

interface ProductInterface extends EntityInterface
{
    public function getName(): string;
    public function getPrice(): float;
    public function isAvailable(): bool;
}