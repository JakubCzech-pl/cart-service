<?php

declare(strict_types=1);

namespace App\Messenger\Catalog;

use App\Exception\Catalog\CouldNotCreateProductException;
use App\Model\ProductInterface;
use App\Service\Catalog\CreateProductService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateProductHandler
{
    public function __construct(private CreateProductService $createProductService) {}

    /**
     * @throws CouldNotCreateProductException
     */
    public function __invoke(CreateProduct $message): ProductInterface
    {
        return $this->createProductService->execute(
            $message->name,
            $message->price,
            $message->isAvailable
        );
    }
}
