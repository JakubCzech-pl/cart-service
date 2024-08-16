<?php

declare(strict_types=1);

namespace App\Tests\Unit\Response\Cart;

use App\Entity\CartItem;
use App\Response\Cart\AddedProductResponseFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class AddedProductResponseFactoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateResponseWithCartItemSet(): void
    {
        $cartItemMock = $this->createMock(CartItem::class);
        $cartItemMock->method('getId')->willReturn(1);
        $cartItemMock->method('getProductName')->willReturn('Product Name');

        $addedProductResponseFactory = new AddedProductResponseFactory();

        $addedProductResponseFactory->setCartItem($cartItemMock);

        $response = $addedProductResponseFactory->create();
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals(
            [
                'message' => 'Added product to cart',
                'itemId' => 1,
                'productName' => 'Product Name',
            ],
            \json_decode($response->getContent(), true)
        );
    }

    public function testCreateResponseWithoutCartItemSet(): void
    {
        $addedProductResponseFactory = new AddedProductResponseFactory();

        $response = $addedProductResponseFactory->create();
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(202, $response->getStatusCode());
        self::assertEquals(
            [],
            \json_decode($response->getContent(), true)
        );
    }
}
