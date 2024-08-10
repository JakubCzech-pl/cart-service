<?php

declare(strict_types=1);

namespace App\Messenger\Cart;

use App\Exception\Cart\CouldNotAddProductToCartException;
use App\Exception\Cart\EntityCandidate\InactiveCartException;
use App\Exception\Cart\EntityCandidate\NotPositiveProductQuantityException;
use App\Exception\Cart\EntityCandidate\ProductNotAvailableException;
use App\Exception\EntityCandidateArgumentException;
use App\Model\Cart\CartInterface;
use App\Model\Cart\CartItemInterface;
use App\Model\Catalog\ProductInterface;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Service\Cart\AddProductServiceInterface;
use App\Service\Cart\CartItemCandidate;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddProductToCartHandler
{
    public function __construct(
        private CartRepository $cartRepository,
        private ProductRepository $productRepository,
        private AddProductServiceInterface $addProductToCartService
    ) {}

    /**
     * @throws CouldNotAddProductToCartException
     */
    public function __invoke(AddProductToCart $message): CartItemInterface
    {
        $cartItemCandidate = $this->createCartItemCandidate(
            $this->getCart($message->cartId),
            $this->getProductToAdd($message->productId),
            $message->quantity
        );

        return $this->addProductToCartService->execute($cartItemCandidate);
    }

    /**
     * @throws CouldNotAddProductToCartException
     */
    private function getProductToAdd(int $productId): ProductInterface
    {
        $product = $this->productRepository->getById($productId);
        if (!$product) {
            throw new CouldNotAddProductToCartException(
                \sprintf('Product with id %s not found', $productId)
            );
        }

        return $product;
    }

    /**
     * @throws CouldNotAddProductToCartException
     */
    private function getCart(int $cartId): CartInterface
    {
        $cart = $this->cartRepository->getById($cartId);
        if (!$cart) {
            throw new CouldNotAddProductToCartException('Cart not found');
        }

        return $cart;
    }

    /**
     * @throws CouldNotAddProductToCartException
     */
    private function createCartItemCandidate(
        CartInterface $cart,
        ProductInterface $product,
        int $quantity
    ): CartItemCandidate {
        try {
            return new CartItemCandidate(
                $cart,
                $product,
                $product->getPrice(),
                $quantity
            );
        } catch (InactiveCartException) {
            throw new CouldNotAddProductToCartException('Cannot add product to Inactive Cart');
        } catch (ProductNotAvailableException) {
            throw new CouldNotAddProductToCartException('Product not available at the moment');
        } catch (NotPositiveProductQuantityException) {
            throw new CouldNotAddProductToCartException('Quantity has to be positive integer number');
        } catch (EntityCandidateArgumentException $exception) {
            throw new CouldNotAddProductToCartException($exception->getMessage());
        }
    }
}
