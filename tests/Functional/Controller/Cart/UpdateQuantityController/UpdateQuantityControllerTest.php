<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\UpdateQuantityController;

use App\Tests\Functional\WebTestCase;

class UpdateQuantityControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([new UpdateQuantityControllerFixture()]);
    }

    public function testUpdateQuantityItemInCart(): void
    {
        $uri = '/cart/item';
        $this->client->request(
            'PATCH',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartItemId' => 2, 'quantity' => 10])
        );

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            ['message' => 'Quantity updated successfully.', 'cartItemId' => 2],
            $response
        );

        $uri = '/cart/2';
        $this->client->request(
            'GET',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            ''
        );

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            [
                'id' => 2,
                'items' => [
                    0 =>  [
                        'id' => 2,
                        'quantity' => 10,
                        'price' => 129.34,
                        'productName' => 'Test Product 2'
                    ]
                ],
                'isActive' => true,
                'totalPrice' => 1293.4,
                'totalQuantity' => 10,
                'active' => true,
                'addressId' => null
            ],
            $response
        );
    }
}
