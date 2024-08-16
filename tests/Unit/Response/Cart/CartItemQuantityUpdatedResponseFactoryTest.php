<?php

declare(strict_types=1);

namespace App\Tests\Unit\Response\Cart;

use App\Entity\CartItem;
use App\Response\Cart\CartItemQuantityUpdatedResponseFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class CartItemQuantityUpdatedResponseFactoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateResponseWithCartItemUpdated(): void
    {
        $cartItemMock = $this->createMock(CartItem::class);
        $cartItemMock->method('getId')->willReturn(1);

        $factory = new CartItemQuantityUpdatedResponseFactory();

        $factory->setCartItem($cartItemMock);

        $response = $factory->create();

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals(
            [
                'message' => 'Quantity updated successfully.',
                'cartItemId' => 1
            ],
            \json_decode($response->getContent(), true)
        );
    }

    public function testCreateResponseWithoutCartItemUpdated(): void
    {
        $factory = new CartItemQuantityUpdatedResponseFactory();

        $response = $factory->create();

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(202, $response->getStatusCode());
        self::assertEquals(
            [],
            \json_decode($response->getContent(), true)
        );
    }
}
