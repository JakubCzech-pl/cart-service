<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Service\Cart\CartCandidate;
use PHPUnit\Framework\TestCase;

class CartCandidateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateCartCandidateWithoutCartItems(): void
    {
        $cartCandidate = new CartCandidate();

        $cartEntity = $cartCandidate->toEntity();
        self::assertInstanceOf(Cart::class, $cartEntity);
        self::assertEmpty($cartEntity->getItems());
        self::assertTrue($cartEntity->isActive());
    }

    public function testCreateCartCandidateWithCartItems(): void
    {
        $cartItemMock = $this->createMock(CartItem::class);
        $cartItemMock->method('getPrice')->willReturn(10.20);
        $cartItemMock->method('getQuantity')->willReturn(1);

        $cartItemMock2 = $this->createMock(CartItem::class);
        $cartItemMock2->method('getPrice')->willReturn(90.90);
        $cartItemMock2->method('getQuantity')->willReturn(3);

        $cartCandidate = new CartCandidate($cartItemMock, $cartItemMock2);

        $cartEntity = $cartCandidate->toEntity();
        self::assertInstanceOf(Cart::class, $cartEntity);
        self::assertTrue($cartEntity->isActive());
        self::assertEquals(4, $cartEntity->getTotalQuantity());
        self::assertEquals(10.20 + 90.90, $cartEntity->getTotalPrice());
    }
}
