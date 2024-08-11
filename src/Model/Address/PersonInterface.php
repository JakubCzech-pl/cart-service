<?php

declare(strict_types=1);

namespace App\Model\Address;

interface PersonInterface
{
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getPhoneNumber(): string;
}