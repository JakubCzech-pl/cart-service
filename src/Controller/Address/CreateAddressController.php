<?php

declare(strict_types=1);

namespace App\Controller\Address;

use App\Messenger\Address\CreateAddress;
use App\Messenger\MessageSerializer;
use App\Response\Address\CreatedAddressResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'address', name: 'create-address', methods: 'POST')]
class CreateAddressController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
        private MessageSerializer $messageSerializer,
        private CreatedAddressResponseFactory $createdAddressResponseFactory
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $address = $this->handle(
            $this->messageSerializer->deserialize($request->getContent(), CreateAddress::class)
        );

        $this->createdAddressResponseFactory->setAddress($address);

        return $this->createdAddressResponseFactory->create();
    }
}
