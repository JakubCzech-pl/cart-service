<?php

declare(strict_types=1);

namespace App\Response\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;

class ExceptionResponseFactory implements ExceptionResponseFactoryInterface
{
    private const DEFAULT_MESSAGE = 'Could not handle your request at the moment';

    private \Throwable $exception;

    public function setException(\Throwable $exception): void
    {
        $this->exception = $exception;
    }

    public function create(): JsonResponse
    {
        return match (true) {
            $this->exception instanceof MissingConstructorArgumentsException => $this->getMissingArgumentsResponse(),
            $this->exception instanceof HandlerFailedException => $this->getHandlerFailedExceptionResponse($this->exception),
            $this->exception instanceof NotFoundHttpException => $this->getEntityNotFoundResponse(),
            default => $this->getDefaultResponse()
        };
    }

    private function getMissingArgumentsResponse(): JsonResponse
    {
        return new JsonResponse(
            [self::MESSAGE_KEY => 'Request data is incomplete'],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    private function getHandlerFailedExceptionResponse(\Throwable $exception): JsonResponse
    {
        return new JsonResponse(
            [self::MESSAGE_KEY => $exception->getPrevious()?->getMessage() ?? self::DEFAULT_MESSAGE],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    private function getEntityNotFoundResponse(): JsonResponse
    {
        return new JsonResponse(
            [self::MESSAGE_KEY => 'Entity not found'],
            Response::HTTP_NOT_FOUND
        );
    }

    private function getDefaultResponse(): JsonResponse
    {
        return new JsonResponse(
            [self::MESSAGE_KEY =>self::DEFAULT_MESSAGE],
            Response::HTTP_BAD_REQUEST
        );
    }
}
