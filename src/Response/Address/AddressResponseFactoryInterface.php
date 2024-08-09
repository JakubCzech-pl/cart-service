<?php

declare(strict_types=1);

namespace App\Response\Address;

use App\Model\Address\AddressInterface;
use App\Response\ResponseFactoryInterface;

interface AddressResponseFactoryInterface extends ResponseFactoryInterface
{
    public function setAddress(AddressInterface $address): void;
}