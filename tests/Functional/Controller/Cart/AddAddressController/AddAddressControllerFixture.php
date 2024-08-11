<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\AddAddressController;

use App\Entity\Address;
use App\Entity\Cart;
use App\Entity\Person;
use App\Entity\Region;
use App\Entity\Street;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class AddAddressControllerFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $cart = new Cart(null, true);
        $inactiveCart = new Cart(null, false);

        $address = new Address(
            new Person('John', 'Doe', '+48123456789'),
            new Region('Podkarpacie', '35-001', 'PL', 'Rzeszów'),
            new Street('Plac Wolności', '1' , 'Z')
        );
        $manager->persist($cart);
        $manager->persist($inactiveCart);
        $manager->persist($address);

        $manager->flush();
    }
}
