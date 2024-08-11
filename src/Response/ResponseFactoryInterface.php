<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ResponseFactoryInterface
{
    public const MESSAGE_KEY = 'message';

    public function create(): JsonResponse;
}