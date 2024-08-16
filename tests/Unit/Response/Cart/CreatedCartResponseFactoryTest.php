<?php

declare(strict_types=1);

namespace App\Tests\Unit\Response\Cart;

use App\Entity\Cart;
use App\Response\Cart\CreatedCartResponseFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreatedCartResponseFactoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateResponseWithCartSet(): void
    {
        $cartMock = $this->createMock(Cart::class);
        $cartMock->method('getId')->willReturn(1);

        $createdCartResponseFactory = new CreatedCartResponseFactory();
        $createdCartResponseFactory->setCart($cartMock);

        $response = $createdCartResponseFactory->create();

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals(
            [
                'message' => 'Cart created successfully.',
                'cartId' => 1
            ],
            \json_decode($response->getContent(), true)
        );
    }

    public function testCreateResponseWithoutCartSet(): void
    {
        $createdCartResponseFactory = new CreatedCartResponseFactory();
        $response = $createdCartResponseFactory->create();

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(202, $response->getStatusCode());
        self::assertEquals(
            [],
            \json_decode($response->getContent(), true)
        );
    }
}
