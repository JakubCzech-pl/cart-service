<?php

declare(strict_types=1);

namespace App\Messenger\Catalog;

use App\Exception\Catalog\CouldNotCreateProductException;
use App\Exception\Catalog\EntityCandidate\NegativeProductPriceException;
use App\Exception\EntityCandidateArgumentException;
use App\Model\Catalog\ProductInterface;
use App\Service\Catalog\CreateProductService;
use App\Service\Catalog\ProductCandidate;
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
        $productCandidate = $this->createCandidate(
            $message->name,
            $message->price,
            $message->isAvailable
        );

        return $this->createProductService->execute($productCandidate);
    }

    /**
     * @throws CouldNotCreateProductException
     */
    private function createCandidate(string $name, float $price, bool $isAvailable): ProductCandidate
    {
        try {
            return new ProductCandidate(
                $name,
                $price,
                $isAvailable
            );
        } catch (NegativeProductPriceException) {
            throw new CouldNotCreateProductException('Product price cannot be negative number');
        } catch (EntityCandidateArgumentException $exception) {
            throw new CouldNotCreateProductException($exception->getMessage());
        }
    }
}
