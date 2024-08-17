<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Cart;

use App\Entity\Address;
use App\Entity\Cart;
use App\Exception\Cart\EntityCandidate\InactiveCartException;
use App\Model\Address\AddressInterface;
use App\Model\Cart\CartInterface;
use App\Service\Cart\AddAddressCandidate;
use PHPUnit\Framework\TestCase;

class AddAddressCandidateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateAddAddressCandidateWithActiveCart(): void
    {
        $cart = $this->createMock(Cart::class);
        $cart->method('isActive')->willReturn(true);

        $address = $this->createMock(Address::class);

        $addAddressCandidate = new AddAddressCandidate($cart, $address);

        self::assertInstanceOf(AddAddressCandidate::class, $addAddressCandidate);
        self::assertInstanceOf(CartInterface::class, $addAddressCandidate->getCart());
        self::assertInstanceOf(AddressInterface::class, $addAddressCandidate->getAddress());
    }

    public function testCannotBeCreatedWithInactiveCart(): void
    {
        $cart = $this->createMock(Cart::class);
        $cart->method('isActive')->willReturn(false);

        $address = $this->createMock(Address::class);

        $this->expectException(InactiveCartException::class);

        new AddAddressCandidate($cart, $address);
    }
}
