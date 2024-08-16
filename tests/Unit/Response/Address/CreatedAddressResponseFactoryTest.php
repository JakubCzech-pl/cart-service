<?php

declare(strict_types=1);

namespace App\Tests\Unit\Response\Address;

use App\Entity\Address;
use App\Response\Address\CreatedAddressResponseFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreatedAddressResponseFactoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateResponseWithAddressSet(): void
    {
        $addressMock = $this->createMock(Address::class);
        $addressMock->method('getId')->willReturn(1);

        $createdAddressResponseFactory = new CreatedAddressResponseFactory();

        $createdAddressResponseFactory->setAddress($addressMock);

        $response = $createdAddressResponseFactory->create();

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals(
            [
                'message' => 'Created Address successfully',
                'addressId' => 1
            ],
            \json_decode($response->getContent(), true)
        );
    }

    public function testCreateResponseWithoutAddressSet(): void
    {
        $createdAddressResponseFactory = new CreatedAddressResponseFactory();

        $response = $createdAddressResponseFactory->create();

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(202, $response->getStatusCode());
        self::assertEquals([], \json_decode($response->getContent(), true));
    }
}
