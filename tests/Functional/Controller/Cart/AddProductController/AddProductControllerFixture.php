<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\AddProductController;

use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class AddProductControllerFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $product1 = new Product('Test Product 1', 12.34, true);
        $products = [
            $product1,
            new Product('Test Product 2', 129.34, true),
            new Product('Test Product 3', 678.99, false),
        ];
        foreach ($products as $product) {
            $manager->persist($product);
        }

        $cart = new Cart(null, true);
        $inActiveCart = new Cart(null, false);
        $manager->persist($cart);
        $manager->persist($inActiveCart);

        $manager->flush();
    }
}
