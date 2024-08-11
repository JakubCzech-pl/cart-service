<?php

declare(strict_types=1);

namespace App\Service\Address;

use App\Entity\Address;
use App\Model\EntityInterface;
use App\Service\EntityCandidateInterface;

class AddressCandidate implements EntityCandidateInterface
{
    public function __construct(
        private PersonCandidate $personCandidate,
        private regionCandidate $regionCandidate,
        private StreetCandidate $streetCandidate,
    ) {}

    public function toEntity(): EntityInterface
    {
        return new Address(
            $this->personCandidate->toPerson(),
            $this->regionCandidate->toRegion(),
            $this->streetCandidate->toStreet(),
        );
    }
}
