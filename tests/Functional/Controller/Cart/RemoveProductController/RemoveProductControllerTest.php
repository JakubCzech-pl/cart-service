<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\RemoveProductController;

use App\Tests\Functional\WebTestCase;

class RemoveProductControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([new RemoveProductControllerFixture()]);
    }

    public function testRemoveProductInCart(): void
    {
        $uri = '/cart';
        $this->client->request(
            'DELETE',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartItemId' => 2, 'cartId' => 2])
        );

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            ['message' => 'Removed product from cart'],
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
                'items' => [],
                'isActive' => true,
                'totalPrice' => 0,
                'totalQuantity' => 0,
                'active' => true,
                'addressId' => null
            ],
            $response
        );
    }

    public function testRemoveProductNotInCart(): void
    {
        $uri = '/cart';
        $this->client->request(
            'DELETE',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['cartItemId' => 1, 'cartId' => 2])
        );

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            ['message' => 'Could not relate given cart with given cart item'],
            $response
        );
    }
}
