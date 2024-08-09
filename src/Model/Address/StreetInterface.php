<?php

declare(strict_types=1);

namespace App\Model\Address;

interface StreetInterface
{
    public function getStreetName(): string;
    public function getStreetNumber(): string;
    public function getStreetAddition(): string;
}