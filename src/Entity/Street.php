<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Address\Street as StreetModel;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Street extends StreetModel
{
    #[ORM\Column(type: 'string')]
    protected string $streetName;

    #[ORM\Column(type: 'string')]
    protected string $streetNumber;

    #[ORM\Column(type: 'string')]
    protected string $streetAddition;
}
