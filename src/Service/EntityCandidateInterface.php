<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\EntityInterface;

interface EntityCandidateInterface
{
    public function toEntity(): EntityInterface;
}