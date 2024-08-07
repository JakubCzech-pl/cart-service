<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\EntityInterface;

class EntityFactory implements EntityFactoryInterface
{
    public function create(EntityCandidateInterface $candidate): EntityInterface
    {
        return $candidate->toEntity();
    }
}
