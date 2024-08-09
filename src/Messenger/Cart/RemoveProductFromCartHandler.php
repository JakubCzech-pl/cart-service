<?php

declare(strict_types=1);

namespace App\Messenger\Cart;

use App\Exception\Cart\CartItemNotInCartException;
use App\Exception\Cart\CouldNotDeleteCartItemException;
use App\Model\Cart\CartInterface;
use App\Model\Cart\CartItemInterface;
use App\Repository\CartItemRepository;
use App\Repository\CartRepository;
use App\Service\Cart\RemovalCartItemCandidate;
use App\Service\Cart\RemoveProductServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RemoveProductFromCartHandler
{
    public function __construct(
        private CartRepository $cartRepository,
        private CartItemRepository $cartItemRepository,
        private RemoveProductServiceInterface $removeProductService
    ) {}

    /**
     * @throws CouldNotDeleteCartItemException
     */
    public function __invoke(RemoveProductFromCart $message): void
    {
        $removalCandidate = $this->createRemovalCandidate(
            $this->getCartItem($message->cartItemId),
            $this->getCart($message->cartId)
        );

        $this->removeProductService->execute($removalCandidate);
    }

    /**
     * @throws CouldNotDeleteCartItemException
     */
    private function getCart(int $cartId): CartInterface
    {
        $cart = $this->cartRepository->getById($cartId);
        if (!$cart) {
            throw new CouldNotDeleteCartItemException('Cart not found');
        }

        return $cart;
    }

    /**
     * @throws CouldNotDeleteCartItemException
     */
    private function getCartItem(int $cartItemId): CartItemInterface
    {
        $cartItem = $this->cartItemRepository->getById($cartItemId);
        if (!$cartItem) {
            throw new CouldNotDeleteCartItemException(
                \sprintf('Cart Item with id %s could not be found', $cartItemId)
            );
        }

        return $cartItem;
    }

    /**
     * @throws CouldNotDeleteCartItemException
     */
    private function createRemovalCandidate(CartItemInterface $cartItem, CartInterface $cart): RemovalCartItemCandidate
    {
        try {
            return new RemovalCartItemCandidate(
                $cartItem,
                $cart
            );
        } catch (CartItemNotInCartException) {
            throw new CouldNotDeleteCartItemException('Could not relate given cart with given cart item');
        }
    }
}
