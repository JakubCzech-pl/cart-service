<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Address\Person as PersonModel;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Person extends PersonModel
{
    #[ORM\Column(type: "string")]
    protected string $firstName;

    #[ORM\Column(type: "string")]
    protected string $lastName;

    #[ORM\Column(type: "string")]
    protected string $phoneNumber;
}
