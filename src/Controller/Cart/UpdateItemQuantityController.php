<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Messenger\Cart\UpdateCartItemQuantity;
use App\Messenger\MessageSerializer;
use App\Response\Cart\CartItemQuantityUpdatedResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'cart/item', name: 'update-cart-item-quantity', methods: 'PATCH')]
class UpdateItemQuantityController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
        private MessageSerializer $messageSerializer,
        private CartItemQuantityUpdatedResponseFactory $cartItemQuantityUpdatedResponseFactory
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $cartItem = $this->handle(
            $this->messageSerializer->deserialize($request->getContent(), UpdateCartItemQuantity::class)
        );

        $this->cartItemQuantityUpdatedResponseFactory->setCartItem($cartItem);

        return $this->cartItemQuantityUpdatedResponseFactory->create();
    }
}
