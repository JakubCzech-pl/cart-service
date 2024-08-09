<?php

declare(strict_types=1);

namespace App\Controller\Address;

use App\Entity\Address;
use App\Response\Address\AddressResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'address/{address}', name: 'show-address', methods: 'GET')]
class ShowAddressController extends AbstractController
{
    public function __construct(private AddressResponseFactory $addressResponseFactory) {}

    public function __invoke(Address $address): JsonResponse
    {
        $this->addressResponseFactory->setAddress($address);

        return $this->addressResponseFactory->create();
    }
}
