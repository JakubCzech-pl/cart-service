<?php

declare(strict_types=1);

namespace App\Listener;

use App\Response\Exception\ExceptionResponseFactoryInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function __construct(private ExceptionResponseFactoryInterface $exceptionResponseFactory) {}

    public function onKernelException(ExceptionEvent $event): void
    {
        $this->exceptionResponseFactory->setException($event->getThrowable());

        $event->setResponse($this->exceptionResponseFactory->create());
    }
}
