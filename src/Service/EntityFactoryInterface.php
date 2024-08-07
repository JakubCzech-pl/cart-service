<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\EntityInterface;

interface EntityFactoryInterface
{
    public function create(EntityCandidateInterface $candidate): EntityInterface;
}