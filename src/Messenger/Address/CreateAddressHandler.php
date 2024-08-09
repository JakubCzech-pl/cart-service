<?php

declare(strict_types=1);

namespace App\Messenger\Address;

use App\Exception\Address\CouldNotCreateAddressException;
use App\Exception\Address\Person\EmptyPersonNameException;
use App\Exception\Address\Person\InvalidPersonDetailsException;
use App\Exception\Address\Person\InvalidPhoneNumberFormatException;
use App\Exception\Address\Person\PersonNameContainDigitsException;
use App\Exception\Address\Region\CountryCodeBeyondStandardsException;
use App\Exception\Address\Region\EmptyCityException;
use App\Exception\Address\Region\EmptyPostCodeException;
use App\Exception\Address\Region\InvalidRegionDetailsException;
use App\Exception\Address\Street\EmptyStreetNameException;
use App\Model\Address\AddressInterface;
use App\Service\Address\AddressCandidate;
use App\Service\Address\CreateAddressServiceInterface;
use App\Service\Address\PersonCandidate;
use App\Service\Address\RegionCandidate;
use App\Service\Address\StreetCandidate;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateAddressHandler
{
    public function __construct(
        private CreateAddressServiceInterface $createAddressService
    ) {}

    /**
     * @throws CouldNotCreateAddressException
     */
    public function __invoke(CreateAddress $createAddress): AddressInterface
    {
        $addressCandidate = new AddressCandidate(
            $this->createPersonCandidate($createAddress->person),
            $this->createRegionCandidate($createAddress->region),
            $this->createStreetCandidate($createAddress->street)
        );

        return $this->createAddressService->create($addressCandidate);
    }

    /**
     * @throws CouldNotCreateAddressException
     */
    private function createPersonCandidate(PersonDto $personDto): PersonCandidate
    {
        try {
            return new PersonCandidate(
                $personDto->firstName,
                $personDto->lastName,
                $personDto->phoneNumber
            );
        } catch (EmptyPersonNameException|PersonNameContainDigitsException) {
            throw new CouldNotCreateAddressException('Name must not be empty or have digits');
        } catch (InvalidPhoneNumberFormatException) {
            throw new CouldNotCreateAddressException('Invalid phone number format');
        } catch (InvalidPersonDetailsException $exception) {
            throw new CouldNotCreateAddressException($exception->getMessage());
        }
    }

    /**
     * @throws CouldNotCreateAddressException
     */
    private function createRegionCandidate(RegionDto $regionDto): RegionCandidate
    {
        try {
            return new RegionCandidate(
                $regionDto->regionName,
                $regionDto->postCode,
                $regionDto->countryCode,
                $regionDto->city
            );
        } catch (EmptyPostCodeException) {
            throw new CouldNotCreateAddressException('Post code cannot be empty');
        } catch (CountryCodeBeyondStandardsException) {
            throw new CouldNotCreateAddressException(
                'Invalid post code. Provide it ISO 3166-1 alpha  standard'
            );
        } catch (EmptyCityException) {
            throw new CouldNotCreateAddressException('City cannot be empty');
        } catch (InvalidRegionDetailsException $exception) {
            throw new CouldNotCreateAddressException($exception->getMessage());
        }
    }

    /**
     * @throws CouldNotCreateAddressException
     */
    private function createStreetCandidate(StreetDto $streetDto): StreetCandidate
    {
        try {
            return new StreetCandidate(
                $streetDto->streetName,
                $streetDto->streetNumber,
                $streetDto->streetAddition
            );
        } catch (EmptyStreetNameException) {
            throw new CouldNotCreateAddressException('Street Name cannot be empty');
        }
    }
}
