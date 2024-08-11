<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Messenger\Cart\CreateCart;
use App\Response\Cart\CreatedCartResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'cart', name: 'create-cart-controller', methods: 'POST')]
class CreateCartController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
        private CreatedCartResponseFactory $createdCartResponseFactory,
    ) {}

    public function __invoke(): JsonResponse
    {
        $cart = $this->handle(new CreateCart());

        $this->createdCartResponseFactory->setCart($cart);

        return $this->createdCartResponseFactory->create();
    }
}
