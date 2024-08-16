<?php

declare(strict_types=1);

namespace App\Tests\Unit\Response\Address;

use App\Entity\Address;
use App\Entity\Person;
use App\Entity\Region;
use App\Entity\Street;
use App\Response\Address\AddressResponseFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AddressResponseFactoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateAddressResponseWithAddressSet(): void
    {
        $address = new Address(
            new Person('John', 'Doe', '+48123456789'),
            new Region('Podkarpacie', '35-001', 'PL', 'Rzeszów'),
            new Street('Plac Wolności', '1' , 'Z')
        );

        $normalizerMock = $this->createMock(NormalizerInterface::class);
        $normalizerMock->method('normalize')->with($address)->willReturn([
            'id' => 1,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'phoneNumber' => '+48123456789',
            'streetName' => 'Plac Wolności',
            'streetNumber' => '1',
            'streetAddition' => 'Z',
            'regionName' => 'Podkarpacie',
            'postCode' => '35-001',
            'city' => 'Rzeszów',
            'countryCode' => 'PL'
        ]);
        $addressResponseFactory = new AddressResponseFactory($normalizerMock);

        $addressResponseFactory->setAddress($address);

        $createdResponse = $addressResponseFactory->create();

        self::assertInstanceOf(JsonResponse::class, $createdResponse);
        self::assertEquals(
            200,
            $createdResponse->getStatusCode()
        );
        self::assertEquals(
            [
                'id' => 1,
                'firstName' => 'John',
                'lastName' => 'Doe',
                'phoneNumber' => '+48123456789',
                'streetName' => 'Plac Wolności',
                'streetNumber' => '1',
                'streetAddition' => 'Z',
                'regionName' => 'Podkarpacie',
                'postCode' => '35-001',
                'city' => 'Rzeszów',
                'countryCode' => 'PL'
            ],
            \json_decode($createdResponse->getContent(), true)
        );
    }

    public function testCreateAddressResponseWithoutAddressSet(): void
    {
        $normalizerMock = $this->createMock(NormalizerInterface::class);
        $addressResponseFactory = new AddressResponseFactory($normalizerMock);

        $createdResponse = $addressResponseFactory->create();

        self::assertInstanceOf(JsonResponse::class, $createdResponse);
        self::assertEquals(202, $createdResponse->getStatusCode());
        self::assertEquals(
            [],
            \json_decode($createdResponse->getContent(), true)
        );
    }

    public function testCreateAddressResponseWithNormalizerException(): void
    {
        $addressMock = $this->createMock(Address::class);

        $normalizerMock = $this->createMock(NormalizerInterface::class);
        $normalizerMock
            ->method('normalize')
            ->with($addressMock)
            ->willThrowException($this->createMock(ExceptionInterface::class))
        ;

        $addressResponseFactory = new AddressResponseFactory($normalizerMock);
        $addressResponseFactory->setAddress($addressMock);

        $createdResponse = $addressResponseFactory->create();

        self::assertInstanceOf(JsonResponse::class, $createdResponse);
        self::assertEquals(200, $createdResponse->getStatusCode());
        self::assertEquals(
            ['message' => 'Cannot process this Address at the moment.'],
            \json_decode($createdResponse->getContent(), true)
        );
    }
}
