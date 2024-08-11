<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Messenger\Cart\RemoveProductFromCart;
use App\Messenger\MessageSerializer;
use App\Response\Cart\ProductRemovedResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'cart', name: 'remove-product-from-cart', methods: 'DELETE')]
class RemoveProductController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
        private MessageSerializer $messageSerializer,
        private ProductRemovedResponseFactory $productRemovedResponseFactory
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $this->handle(
            $this->messageSerializer->deserialize($request->getContent(), RemoveProductFromCart::class)
        );

        return $this->productRemovedResponseFactory->create();
    }
}
