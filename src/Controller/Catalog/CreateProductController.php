<?php

declare(strict_types=1);

namespace App\Controller\Catalog;

use App\Messenger\Catalog\CreateProduct;
use App\Messenger\MessageInterface;
use App\Messenger\MessageSerializer;
use App\Response\Catalog\CreatedProductResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'catalog/product', name: 'create-product', methods: 'POST')]
class CreateProductController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private MessageSerializer $messageSerializer,
        private MessageBusInterface $messageBus,
        private CreatedProductResponseFactory $createdProductResponseFactory,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $product = $this->handle(
            $this->createMessage($request->getContent())
        );

        $this->createdProductResponseFactory->setProduct($product);

        return $this->createdProductResponseFactory->create();
    }

    private function createMessage(string $requestBody): MessageInterface
    {
        return $this->messageSerializer->deserialize($requestBody, CreateProduct::class);
    }
}
