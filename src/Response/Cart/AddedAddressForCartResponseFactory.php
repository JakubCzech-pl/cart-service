<?php

declare(strict_types=1);

namespace App\Response\Cart;

use App\Response\ResponseFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AddedAddressForCartResponseFactory implements ResponseFactoryInterface
{
    public function create(): JsonResponse
    {
        return new JsonResponse([self::MESSAGE_KEY => 'Address assigned to Cart']);
    }
}
