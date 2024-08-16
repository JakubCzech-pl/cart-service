<?php

declare(strict_types=1);

namespace App\Tests\Unit\Response\Cart;

use App\Entity\Cart;
use App\Response\Cart\CartResponseFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CartResponseFactoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateResponseWithCartSet(): void
    {
        $cart = new Cart(null, true);

        $normalizerMock = $this->createMock(NormalizerInterface::class);
        $normalizerMock->method('normalize')->with($cart)->willReturn([
            'id' => 1,
            'items' => [],
            'totalPrice' => 0,
            'totalQuantity' => 0,
            'active' => true,
            'addressId' => null
        ]);

        $cartResponseFactory = new CartResponseFactory($normalizerMock);
        $cartResponseFactory->setCart($cart);

        $response = $cartResponseFactory->create();
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals(
            [
                'id' => 1,
                'items' => [],
                'totalPrice' => 0,
                'totalQuantity' => 0,
                'active' => true,
                'addressId' => null
            ],
            \json_decode($response->getContent(), true)
        );
    }

    public function testCreateResponseWithoutCartSet(): void
    {
        $normalizerMock = $this->createMock(NormalizerInterface::class);
        $cartResponseFactory = new CartResponseFactory($normalizerMock);

        $response = $cartResponseFactory->create();
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(202, $response->getStatusCode());
        self::assertEquals(
            [],
            \json_decode($response->getContent(), true)
        );
    }

    public function testCreateResponseWithNormalizerException(): void
    {
        $cartMock = $this->createMock(Cart::class);

        $normalizerMock = $this->createMock(NormalizerInterface::class);
        $normalizerMock
            ->method('normalize')
            ->with($cartMock)
            ->willThrowException($this->createMock(ExceptionInterface::class))
        ;

        $cartResponseFactory = new CartResponseFactory($normalizerMock);
        $cartResponseFactory->setCart($cartMock);

        $response = $cartResponseFactory->create();
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals(
            ['message' => 'Cannot Process this Cart at the moment.'],
            \json_decode($response->getContent(), true)
        );
    }
}
