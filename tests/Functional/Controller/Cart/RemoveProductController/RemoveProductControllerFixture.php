<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\RemoveProductController;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class RemoveProductControllerFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $product1 = new Product('Test Product 1', 12.34, true);
        $product2 = new Product('Test Product 2', 129.34, true);
        $product3 = new Product('Test Product 3', 678.99, false);

        foreach ([$product1, $product2, $product3] as $product) {
            $manager->persist($product);
        }

        $cart = new Cart(null, true);
        $cart2 = new Cart(null, true);
        $manager->persist($cart);
        $manager->persist($cart2);

        $cartItem = new CartItem($cart, $product1, $product1->getPrice(), 2);
        $cartItem2 = new CartItem($cart2, $product2, $product2->getPrice(), 1);
        $manager->persist($cartItem);
        $manager->persist($cartItem2);

        $manager->flush();
    }
}
