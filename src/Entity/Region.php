<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Address\Region as RegionModel;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Region extends RegionModel
{
    #[ORM\Column(type: 'string')]
    protected string $countryCode;

    #[ORM\Column(type: 'string')]
    protected string $regionName;

    #[ORM\Column(type: 'string')]
    protected string $city;

    #[ORM\Column(type: 'string')]
    protected string $postcode;
}
