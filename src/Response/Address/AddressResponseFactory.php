<?php

declare(strict_types=1);

namespace App\Response\Address;

use App\Model\Address\AddressInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AddressResponseFactory implements AddressResponseFactoryInterface
{
    public function __construct(private NormalizerInterface $normalizer) {}

    private ?AddressInterface $address = null;

    public function setAddress(AddressInterface $address): void
    {
        $this->address = $address;
    }

    public function create(): JsonResponse
    {
        if (!$this->address) {
            return new JsonResponse([], Response::HTTP_ACCEPTED);
        }

        return new JsonResponse($this->normalizeAddress());
    }

    private function normalizeAddress(): array
    {
        return $this->normalizer->normalize($this->address);
    }
}
