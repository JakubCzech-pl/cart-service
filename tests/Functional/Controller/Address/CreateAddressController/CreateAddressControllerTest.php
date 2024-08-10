<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Address\CreateAddressController;

use App\Tests\Functional\WebTestCase;

class CreateAddressControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateAddress(): void
    {
        $uri = '/address';
        $this->client->request(
            'POST',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($this->getAddressArray())
        );

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            ['message' => 'Created Address successfully', 'addressId' => 1],
            $response
        );

        $this->client->request(
            'GET',
            $uri . '/' . $response['addressId'],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            ''
        );

        $response = $this->getJsonResponseAsArray();

        self::assertEquals(
            [
                'id' => 1,
                'firstName' => 'John',
                'lastName' => 'Doe',
                'phoneNumber' => '+48123456789',
                'regionName' => 'Podkarpacie',
                'postCode' => '35-001',
                'countryCode' => 'PL',
                'city' => 'Rzeszów',
                'streetName' => 'Plac Wolności',
                'streetNumber' => '1',
                'streetAddition' => 'Z'
            ],
            $response,
        );
    }

    private function getAddressArray(): array
    {
        return [
            'person' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'phoneNumber' => '+48123456789',
            ],
            'region' => [
                'regionName' => 'Podkarpacie',
                'postCode' => '35-001',
                'countryCode' => 'PL',
                'city' => 'Rzeszów'
            ],
            'street' => [
                'streetName' => 'Plac Wolności',
                'streetNumber' => '1',
                'streetAddition' => 'Z'
            ]
        ];
    }
}
