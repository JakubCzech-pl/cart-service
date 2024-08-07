<?php

declare(strict_types=1);

namespace App\Model;

class Product implements ProductInterface
{
    protected int $id;
    protected string $name;
    protected float $price;
    protected bool $isAvailable;

    public function __construct(string $name, int $price, bool $isAvailable)
    {
        $this->name = $name;
        $this->price = $price;
        $this->isAvailable = $isAvailable;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }
}
