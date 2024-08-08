<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ResponseFactoryInterface
{
    public function create(): JsonResponse;
}