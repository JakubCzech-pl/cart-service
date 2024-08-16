<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\AddAddressController;

use App\Tests\Functional\WebTestCase;

class AddAddressControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([new AddAddressControllerFixture()]);
    }

    public function testAddAddressForActiveCart(): void
    {
        $uri = '/cart/address';
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartId' => 1, 'addressId' => 1])
        );
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            ['message' => 'Address assigned to Cart'],
            $response
        );

        $this->client->request(
            'GET',
            '/cart/' . 1,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            ''

        );

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            [
                'id' => 1,
                'items' => [],
                'isActive' => true,
                'totalPrice' => 0,
                'totalQuantity' => 0,
                'active' => true,
                'addressId' => 1
            ],
            $response
        );
    }

    public function testAddAddressForInactiveCart(): void
    {
        $uri = '/cart/address';
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartId' => 2, 'addressId' => 1])
        );
        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            ['message' => 'Cannot add address to an inactive cart'],
            $response
        );
    }

    public function testAddNotExistingAddressForCart(): void
    {
        $uri = '/cart/address';
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartId' => 1, 'addressId' => 10])
        );
        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponseAsArray();
        self::assertEquals(
            ['message' => 'Address not found'],
            $response
        );
    }

    public function testAddNotExistingAddressForInactiveActiveCart(): void
    {
        $uri = '/cart/address';
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartId' => 2, 'addressId' => 10])
        );
        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponseAsArray();
        self::assertEquals(
            ['message' => 'Address not found'],
            $response
        );
    }

    public function testAddAddressForNotExistingCart(): void
    {
        $uri = '/cart/address';
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartId' => 7, 'addressId' => 1])
        );
        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponseAsArray();
        self::assertEquals(
            ['message' => 'Cart not found'],
            $response
        );
    }

    public function testAddNotExistingAddressToNotExistingCart(): void
    {
        $uri = '/cart/address';
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartId' => 7, 'addressId' => 8])
        );
        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponseAsArray();
        self::assertEquals(
            ['message' => 'Cart not found'],
            $response
        );
    }
}
