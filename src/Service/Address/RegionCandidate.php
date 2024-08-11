<?php

declare(strict_types=1);

namespace App\Service\Address;

use App\Entity\Region;
use App\Exception\Address\Region\InvalidRegionDetailsException;
use App\Service\Address\Trait\RegionCityValidatorTrait;
use App\Service\Address\Trait\RegionCountryCodeValidatorTrait;
use App\Service\Address\Trait\RegionPostCodeValidatorTrait;

class RegionCandidate
{
    use RegionPostCodeValidatorTrait;
    use RegionCountryCodeValidatorTrait;
    use RegionCityValidatorTrait;

    private string $regionName;
    private string $postCode;
    private string $countryCode;
    private string $city;

    /**
     * @throws InvalidRegionDetailsException
     */
    public function __construct(string $regionName, string $postCode, string $countryCode, string $city)
    {
        $this->validatePostCode($postCode);
        $this->validateCountryCode($countryCode);
        $this->validateCity($city);

        $this->regionName = $regionName;
        $this->postCode = $postCode;
        $this->countryCode = $countryCode;
        $this->city = $city;
    }

    public function toRegion(): Region
    {
        return new Region(
            $this->regionName,
            $this->postCode,
            $this->countryCode,
            $this->city
        );
    }
}
