<?php

declare(strict_types=1);

namespace App\Response;

interface ExceptionResponseFactoryInterface extends ResponseFactoryInterface
{
    public const MESSAGE_KEY = 'message';

    public function setException(\Throwable $exception): void;
}