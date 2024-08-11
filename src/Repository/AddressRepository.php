<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    public function save(Address $address): void
    {
        $this->getEntityManager()->persist($address);
        $this->getEntityManager()->flush();
    }

    public function getById(int $addressId): ?Address
    {
        try {
            return $this->createQueryBuilder('a')
                ->where('a.id = :id')
                ->setParameter('id', $addressId)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }
}
