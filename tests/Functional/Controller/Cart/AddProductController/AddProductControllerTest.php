<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\AddProductController;

use App\Tests\Functional\WebTestCase;

class AddProductControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([new AddProductControllerFixture()]);
    }

    public function testAddProductToCartWithValidRequest(): void
    {
        $uri = '/cart';
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartId' => 1, 'productId' => 1, 'quantity' => 2])
        );
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            [
                'message' => 'Added product to cart',
                'itemId' => 1,
                'productName' => 'Test Product 1',
            ],
            $response
        );

        $this->client->request(
            'GET',
            $uri . '/' . 1,
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
                'items' => [
                    0 =>  [
                        'id' => 1,
                        'quantity' => 2,
                        'price' => 24.68,
                        'productName' => 'Test Product 1'
                    ]
                ],
                'isActive' => true,
                'totalPrice' => 24.68,
                'totalQuantity' => 2,
                'active' => true,
                'addressId' => null
            ],
            $response
        );
    }

    public function testAddProductToCartWithInactiveCart(): void
    {
        $uri = '/cart';
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartId' => 2, 'productId' => 1, 'quantity' => 1])
        );
        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            [
                'message' => 'Cannot add product to Inactive Cart',
            ],
            $response
        );
    }

    public function testAddProductToCartWithInvalidRequest(): void
    {
        $uri = '/cart';
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartId' => 1, 'productId' => 1])
        );
        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            [
                'message' => 'Request data is incomplete',
            ],
            $response
        );

        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['productId' => 1])
        );
        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            [
                'message' => 'Request data is incomplete',
            ],
            $response
        );
    }

    public function testAddInactiveProductToCart(): void
    {
        $uri = '/cart';
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartId' => 1, 'productId' => 3, 'quantity' => 1])
        );
        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            [
                'message' => 'Product not available at the moment',
            ],
            $response
        );
    }
}
