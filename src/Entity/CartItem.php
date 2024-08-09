<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Cart\CartInterface;
use App\Model\Cart\CartItem as CartItemModel;
use App\Model\Catalog\ProductInterface;
use App\Repository\CartItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: CartItemRepository::class)]
#[ORM\Table(name: 'cart_item')]
class CartItem extends CartItemModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected int $id;

    #[Ignore]
    #[ORM\ManyToOne(targetEntity: 'Cart', cascade: ['persist'], inversedBy: 'cartItem')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    protected CartInterface $cart;

    #[ORM\ManyToOne(targetEntity: 'Product', cascade: ['persist'], inversedBy: 'cartItem')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    protected ProductInterface $product;

    #[ORM\Column(type: 'integer', nullable: false)]
    protected int $quantity;

    #[ORM\Column(type: 'float', nullable: false)]
    protected float $price;
}
