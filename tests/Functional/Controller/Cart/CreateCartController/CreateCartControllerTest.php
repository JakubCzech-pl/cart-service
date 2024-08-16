<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\CreateCartController;

use App\Tests\Functional\WebTestCase;

class CreateCartControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateCart(): void
    {
        $uri = '/cart';
        $this->client->request('POST', $uri);
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponseAsArray();

        $expectedCartId = 1;

        self::assertEquals(
            [
                'message' => 'Cart created successfully.',
                'cartId' => $expectedCartId
            ],
            $response
        );

        $this->client->request(
            'GET',
            $uri . '/' . $response['cartId'],
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
                'addressId' => null
            ],
            $response
        );
    }
}
