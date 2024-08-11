<?php

declare(strict_types=1);

namespace App\Messenger\Cart;

use App\Model\Cart\CartInterface;
use App\Service\Cart\CartCandidate;
use App\Service\Cart\CreateCartService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateCartHandler
{
    public function __construct(private CreateCartService $createCartService) {}

    public function __invoke(CreateCart $message): CartInterface
    {
        return $this->createCartService->execute(new CartCandidate());
    }
}
