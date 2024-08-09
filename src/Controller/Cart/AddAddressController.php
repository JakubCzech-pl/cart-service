<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Messenger\Cart\AddAddress;
use App\Messenger\MessageSerializer;
use App\Response\Cart\AddedAddressForCartResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'cart/address', name: 'add-address-for-cart', methods: 'PUT')]
class AddAddressController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
        private MessageSerializer $messageSerializer,
        private AddedAddressForCartResponseFactory $addedAddressForCartResponseFactory
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $this->handle(
            $this->messageSerializer->deserialize($request->getContent(), AddAddress::class)
        );

        return $this->addedAddressForCartResponseFactory->create();
    }
}
