<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Exception\Cart\EntityCandidate\InactiveCartException;
use App\Exception\Cart\EntityCandidate\NotPositiveProductQuantityException;
use App\Exception\Cart\EntityCandidate\ProductNotAvailableException;
use App\Service\Cart\CartItemCandidate;
use PHPUnit\Framework\TestCase;

class CartItemCandidateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateCandidateWithValidDetails(): void
    {
        $cartMock = $this->createMock(Cart::class);
        $cartMock->method('isActive')->willReturn(true);

        $productMock = $this->createMock(Product::class);
        $productMock->method('isAvailable')->willReturn(true);
        $productMock->method('getPrice')->willReturn(10.45);

        $cartItemCandidate = new CartItemCandidate(
            $cartMock,
            $productMock,
            $productMock->getPrice(),
            2
        );
        self::assertInstanceOf(CartItemCandidate::class, $cartItemCandidate);

        $cartItemEntity = $cartItemCandidate->toEntity();
        self::assertInstanceOf(CartItem::class, $cartItemEntity);
        self::assertEquals(10.45 * 2, $cartItemEntity->getPrice());
        self::assertEquals(2, $cartItemEntity->getQuantity());
    }

    public function testCannotCreateCandidateWithInActiveCart(): void
    {
        $cartMock = $this->createMock(Cart::class);
        $cartMock->method('isActive')->willReturn(false);

        $productMock = $this->createMock(Product::class);
        $productMock->method('isAvailable')->willReturn(true);
        $productMock->method('getPrice')->willReturn(10.45);

        $this->expectException(InactiveCartException::class);

        new CartItemCandidate(
            $cartMock,
            $productMock,
            $productMock->getPrice(),
            2
        );
    }

    public function testCannotCreateCandidateWithNotAvailableProduct(): void
    {
        $cartMock = $this->createMock(Cart::class);
        $cartMock->method('isActive')->willReturn(true);

        $productMock = $this->createMock(Product::class);
        $productMock->method('isAvailable')->willReturn(false);
        $productMock->method('getPrice')->willReturn(10.45);

        $this->expectException(ProductNotAvailableException::class);

        new CartItemCandidate(
            $cartMock,
            $productMock,
            $productMock->getPrice(),
            2
        );
    }

    public function testCannotCreateCandidateWithNotAvailableQuantity(): void
    {
        $cartMock = $this->createMock(Cart::class);
        $cartMock->method('isActive')->willReturn(true);

        $productMock = $this->createMock(Product::class);
        $productMock->method('isAvailable')->willReturn(true);
        $productMock->method('getPrice')->willReturn(10.45);

        $this->expectException(NotPositiveProductQuantityException::class);

        new CartItemCandidate(
            $cartMock,
            $productMock,
            $productMock->getPrice(),
            0
        );
    }
}
