<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Messenger\Cart\AddProductToCart;
use App\Messenger\MessageInterface;
use App\Messenger\MessageSerializer;
use App\Response\Cart\AddedProductResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'cart', name: 'add-product-to-cart', methods: 'PUT')]
class AddProductController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
        private MessageSerializer $messageSerializer,
        private AddedProductResponseFactory $addedProductResponseFactory,
    ) {}

    public function __invoke(Request $request): Response
    {
        $cartItem = $this->handle(
            $this->createMessage($request->getContent())
        );

        $this->addedProductResponseFactory->setCartItem($cartItem);

        return $this->addedProductResponseFactory->create();
    }

    private function createMessage(string $requestBody): MessageInterface
    {
        return  $this->messageSerializer->deserialize($requestBody, AddProductToCart::class);
    }
}
