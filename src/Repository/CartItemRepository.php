<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CartItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class CartItemRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct($registry, CartItem::class);
    }

    public function save(CartItem $cart): void
    {
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }

    public function delete(CartItem $cartItem): void
    {
        $this->entityManager->remove($cartItem);
        $this->entityManager->flush();
    }

    public function getById(int $cartItemId): ?CartItem
    {
        try {
            return $this->createQueryBuilder('ci')
                ->where('ci.id = :id')
                ->setParameter('id', $cartItemId)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function updateCartItemQuantity(int $cartItemId, int $quantity): void
    {
        $this->createQueryBuilder('ci')
            ->update()
            ->set('ci.quantity', ':quantity')
            ->where('ci.id = :cartItemId')
            ->setParameter('cartItemId', $cartItemId)
            ->setParameter('quantity', $quantity)
            ->getQuery()
            ->execute();
    }
}
