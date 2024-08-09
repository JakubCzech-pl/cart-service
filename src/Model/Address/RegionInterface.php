<?php

declare(strict_types=1);

namespace App\Model\Address;

interface RegionInterface
{
    public function getRegionName(): string;
    public function getPostCode(): string;
    public function getCity(): string;
    public function getCountryCode(): string;
}