<?php

declare(strict_types=1);

namespace App\Messenger\Cart;

use App\Exception\Cart\CouldNotUpdateItemQuantityException;
use App\Exception\Cart\EntityCandidate\NotPositiveProductQuantityException;
use App\Model\Cart\CartItemInterface;
use App\Repository\CartItemRepository;
use App\Service\Cart\UpdateCartItemQuantityCandidate;
use App\Service\Cart\UpdateCartItemQuantityServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateCartItemQuantityHandler
{
    public function __construct(
        private CartItemRepository $cartItemRepository,
        private UpdateCartItemQuantityServiceInterface $updateCartItemQuantityService
    ) {}

    public function __invoke(UpdateCartItemQuantity $message): CartItemInterface
    {
        $cartItem = $this->getCartItem($message->cartItemId);

        $this->updateCartItemQuantityService->execute(
            $this->createUpdateQuantityCandidate($cartItem, $message->quantity)
        );

        return $cartItem;
    }

    /**
     * @throws CouldNotUpdateItemQuantityException
     */
    private function getCartItem(int $cartItemId): CartItemInterface
    {
        $cartItem = $this->cartItemRepository->getById($cartItemId);
        if (!$cartItem) {
            throw new CouldNotUpdateItemQuantityException(
                \sprintf('Cart Item with id %s could not be found', $cartItemId)
            );
        }

        return $cartItem;
    }

    /**
     * @throws CouldNotUpdateItemQuantityException
     */
    private function createUpdateQuantityCandidate(
        CartItemInterface $cartItem,
        int $quantity
    ): UpdateCartItemQuantityCandidate {
        try {
            return new UpdateCartItemQuantityCandidate($cartItem, $quantity);
        } catch (NotPositiveProductQuantityException) {
            throw new CouldNotUpdateItemQuantityException('Quantity has to be positive integer');
        }
    }
}
