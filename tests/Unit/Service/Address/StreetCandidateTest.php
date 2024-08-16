<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Address;

use App\Entity\Street;
use App\Exception\Address\Street\EmptyStreetNameException;
use App\Service\Address\StreetCandidate;
use PHPUnit\Framework\TestCase;

class StreetCandidateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateStreetCandidateWithValidDetails(): void
    {
        $streetCandidate = new StreetCandidate(
            'Plac Wolności',
            '1A',
            '2'
        );

        self::assertInstanceOf(StreetCandidate::class, $streetCandidate);
        self::assertInstanceOf(Street::class, $streetCandidate->toStreet());

        $streetCandidate = new StreetCandidate(
            'Plac Wolności',
            '',
            ''
        );

        self::assertInstanceOf(StreetCandidate::class, $streetCandidate);
        self::assertInstanceOf(Street::class, $streetCandidate->toStreet());
    }

    public function testCreateStreetCandidateWithInvalidStreetName(): void
    {
        $this->expectException(EmptyStreetNameException::class);

        new StreetCandidate('', '1C','2');
    }
}
