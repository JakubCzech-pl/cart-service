<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\Response\Cart\CartResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'cart/{cart}', name: 'show-cart', methods: 'GET')]
class ShowCartController extends AbstractController
{
    public function __construct(private CartResponseFactory $cartResponseFactory) {}

    public function __invoke(Cart $cart): JsonResponse
    {
        $this->cartResponseFactory->setCart($cart);

        return $this->cartResponseFactory->create();
    }
}
