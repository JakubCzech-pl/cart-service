<?php

declare(strict_types=1);

namespace App\Service\Address;

use App\Model\Address\AddressInterface;

interface CreateAddressServiceInterface
{
    public function create(AddressCandidate $addressCandidate): AddressInterface;
}