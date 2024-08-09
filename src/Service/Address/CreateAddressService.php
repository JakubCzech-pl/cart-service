<?php

declare(strict_types=1);

namespace App\Service\Address;

use App\Model\Address\AddressInterface;
use App\Repository\AddressRepository;
use App\Service\EntityFactoryInterface;

class CreateAddressService implements CreateAddressServiceInterface
{
    public function __construct(
        private EntityFactoryInterface $entityFactory,
        private AddressRepository $addressRepository
    ) {}

    public function create(AddressCandidate $addressCandidate): AddressInterface
    {
       $address = $this->entityFactory->create($addressCandidate);

       $this->addressRepository->save($address);

       return $address;
    }
}
