<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Address;

use App\Entity\Region;
use App\Exception\Address\Region\CountryCodeBeyondStandardsException;
use App\Exception\Address\Region\EmptyCityException;
use App\Exception\Address\Region\EmptyPostCodeException;
use App\Service\Address\RegionCandidate;
use PHPUnit\Framework\TestCase;

class RegionCandidateTest extends TestCase
{
    public function testCanCreateWithValidDetails(): void
    {
        $regionCandidate = new RegionCandidate(
            'Podkarpacie',
            '35-001',
            'PL',
            'Rzeszów'
        );

        self::assertInstanceOf(RegionCandidate::class, $regionCandidate);
        self::assertInstanceOf(Region::class, $regionCandidate->toRegion());
    }

    public function testCannotCreateWithEmptyPostCode(): void
    {
        $this->expectException(EmptyPostCodeException::class);

        new RegionCandidate(
            'Podkarpacie',
            '',
            'PL',
            'Rzeszów'
        );
    }

    public function testCannotCreateWithInvalidCountryCode(): void
    {
        $this->expectException(CountryCodeBeyondStandardsException::class);

        new RegionCandidate(
            'Podkarpacie',
            '35-001',
            'Polska',
            'Rzeszów'
        );
    }

    public function testCannotCreateWithEmptyCity(): void
    {
        $this->expectException(EmptyCityException::class);

        new RegionCandidate(
            'Podkarpacie',
            '35-001',
            'PL',
            ''
        );
    }
}
