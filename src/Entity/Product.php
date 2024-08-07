<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Product as ProductModel;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'product')]
class Product extends ProductModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected int $id;

    #[ORM\Column(type: "string", length: 255)]
    protected string $name;

    #[ORM\Column(type: 'float', nullable: false)]
    protected float $price;

    #[ORM\Column(type: "boolean")]
    protected bool $isAvailable;
}
