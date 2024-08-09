<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Cart\Cart as CartModel;
use App\Repository\CartRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
#[ORM\Table(name: 'cart')]
class Cart extends CartModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected int $id;

    #[ORM\OneToMany(targetEntity: 'CartItem', mappedBy: 'cart', cascade: ['persist', 'remove'], orphanRemoval: true)]
    protected Collection $items;

    #[ORM\Column(type: "boolean")]
    protected bool $isActive;
}
