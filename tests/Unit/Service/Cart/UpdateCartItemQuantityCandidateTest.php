<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Cart;

use App\Entity\CartItem;
use App\Exception\Cart\EntityCandidate\NotPositiveProductQuantityException;
use App\Service\Cart\UpdateCartItemQuantityCandidate;
use PHPUnit\Framework\TestCase;

class UpdateCartItemQuantityCandidateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateCandidateWithValidQuantity(): void
    {
        $cartItemMock = $this->createMock(CartItem::class);
        $cartItemMock->method('getId')->willReturn(1);

        $updateCartItemQuantityCandidate = new UpdateCartItemQuantityCandidate($cartItemMock, 3);

        self::assertInstanceOf(UpdateCartItemQuantityCandidate::class, $updateCartItemQuantityCandidate);
        self::assertEquals(3, $updateCartItemQuantityCandidate->getQuantity());
        self::assertEquals(1, $updateCartItemQuantityCandidate->getCartItemId());
    }

    public function testCreateCandidateWithInvalidQuantity(): void
    {
        $cartItemMock = $this->createMock(CartItem::class);

        $this->expectException(NotPositiveProductQuantityException::class);

        new UpdateCartItemQuantityCandidate($cartItemMock, -3);
    }
}
