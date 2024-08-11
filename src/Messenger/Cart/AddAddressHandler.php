<?php

declare(strict_types=1);

namespace App\Messenger\Cart;

use App\Exception\Cart\CouldNotAddAddressForCartException;
use App\Exception\Cart\EntityCandidate\InactiveCartException;
use App\Model\Address\AddressInterface;
use App\Model\Cart\CartInterface;
use App\Repository\AddressRepository;
use App\Repository\CartRepository;
use App\Service\Cart\AddAddressCandidate;
use App\Service\Cart\AddAddressServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddAddressHandler
{
    public function __construct(
        private CartRepository $cartRepository,
        private AddressRepository $addressRepository,
        private AddAddressServiceInterface $addAddressService
    ) {}

    /**
     * @throws CouldNotAddAddressForCartException
     */
    public function __invoke(AddAddress $message): void
    {
        $addAddressCandidate = $this->createAddAddressCandidate(
            $this->getCart($message->cartId),
            $this->getAddress($message->addressId),
        );

        $this->addAddressService->execute($addAddressCandidate);
    }

    /**
     * @throws CouldNotAddAddressForCartException
     */
    private function getCart(int $cartId): CartInterface
    {
        $cart = $this->cartRepository->getById($cartId);
        if (!$cart) {
            throw new CouldNotAddAddressForCartException('Cart not found');
        }

        return $cart;
    }

    /**
     * @throws CouldNotAddAddressForCartException
     */
    private function getAddress(int $addressId): AddressInterface
    {
        $address = $this->addressRepository->getById($addressId);
        if (!$address) {
            throw new CouldNotAddAddressForCartException('Address not found');
        }

        return $address;
    }

    /**
     * @throws CouldNotAddAddressForCartException
     */
    private function createAddAddressCandidate(CartInterface $cart, AddressInterface $address): AddAddressCandidate
    {
        try {
            return new AddAddressCandidate($cart, $address);
        } catch (InactiveCartException) {
            throw new CouldNotAddAddressForCartException('Cannot add address to an inactive cart');
        }
    }
}
