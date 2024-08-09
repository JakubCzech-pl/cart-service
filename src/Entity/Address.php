<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Address\Address as AddressModel;
use App\Model\Address\PersonInterface;
use App\Model\Address\RegionInterface;
use App\Model\Address\StreetInterface;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ORM\Table(name: 'address')]
class Address extends AddressModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected int $id;

    #[ORM\Embedded(class: Person::class, columnPrefix: false)]
    protected PersonInterface $person;

    #[ORM\Embedded(class: Region::class, columnPrefix: false)]
    protected RegionInterface $region;

    #[ORM\Embedded(class: Street::class, columnPrefix: false)]
    protected StreetInterface $street;
}
