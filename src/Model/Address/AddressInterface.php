<?php

declare(strict_types=1);

namespace App\Model\Address;

use App\Model\EntityInterface;

interface AddressInterface extends EntityInterface, PersonInterface, RegionInterface, StreetInterface
{
}