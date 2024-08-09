<?php

declare(strict_types=1);

namespace App\Response\Cart;

use App\Response\ResponseFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductRemovedResponseFactory implements ResponseFactoryInterface
{
    public function create(): JsonResponse
    {
        return new JsonResponse([self::MESSAGE_KEY => 'Removed product from cart']);
    }
}
