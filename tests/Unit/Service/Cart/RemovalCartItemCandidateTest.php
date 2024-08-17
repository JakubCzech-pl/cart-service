<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Exception\Cart\CartItemNotInCartException;
use App\Service\Cart\RemovalCartItemCandidate;
use PHPUnit\Framework\TestCase;

class RemovalCartItemCandidateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateCandidateWithCartItemInCart(): void
    {
        $cartMock = $this->createMock(Cart::class);
        $cartMock->method('getId')->willReturn(1);

        $cartItemMock = $this->createMock(CartItem::class);

        $cartMock->method('hasItem')->with($cartItemMock)->willReturn(true);
        $cartItemMock->method('getCart')->willReturn($cartMock);

        $removalCartItemCandidate = new RemovalCartItemCandidate($cartItemMock, $cartMock);
        self::assertInstanceOf(RemovalCartItemCandidate::class, $removalCartItemCandidate);

        $cartItemEntityToRemove = $removalCartItemCandidate->toEntity();
        self::assertInstanceOf(CartItem::class, $cartItemEntityToRemove);
    }

    public function testCreateCandidateWithCartItemNotInCart(): void
    {
        $cartMock = $this->createMock(Cart::class);
        $cartMock->method('getId')->willReturn(1);

        $cartItemMock = $this->createMock(CartItem::class);

        $cartMock->method('hasItem')->with($cartItemMock)->willReturn(false);

        $this->expectException(CartItemNotInCartException::class);

        new RemovalCartItemCandidate($cartItemMock, $cartMock);
    }
}
