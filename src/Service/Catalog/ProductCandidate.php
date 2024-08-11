<?php

declare(strict_types=1);

namespace App\Service\Catalog;

use App\Entity\Product;
use App\Exception\Catalog\EntityCandidate\NegativeProductPriceException;
use App\Exception\Catalog\EntityCandidate\ProductNameTooLongException;
use App\Exception\Catalog\EntityCandidate\ProductNameTooShortException;
use App\Exception\EntityCandidateArgumentException;
use App\Model\EntityInterface;
use App\Service\Catalog\Trait\ProductNameLengthValidatorTrait;
use App\Service\Catalog\Trait\ProductPriceValidatorTrait;
use App\Service\EntityCandidateInterface;

class ProductCandidate implements EntityCandidateInterface
{
    use ProductNameLengthValidatorTrait;
    use ProductPriceValidatorTrait;

    private string $name;
    private float $price;
    private bool $isAvailable;

    /**
     * @throws EntityCandidateArgumentException
     */
    public function __construct(string $name, float $price, bool $isAvailable)
    {
        $this->validateProductNameLength($name);
        $this->validatePrice($price);

        $this->name = $name;
        $this->price = $price;
        $this->isAvailable = $isAvailable;
    }

    public function toEntity(): EntityInterface
    {
        return new Product(
            $this->name,
            $this->price,
            $this->isAvailable
        );
    }
}
