<?php

declare(strict_types=1);

namespace App\Response\Exception;

use App\Response\ResponseFactoryInterface;

interface ExceptionResponseFactoryInterface extends ResponseFactoryInterface
{
    public function setException(\Throwable $exception): void;
}