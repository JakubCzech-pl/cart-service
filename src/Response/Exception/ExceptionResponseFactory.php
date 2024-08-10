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
            $this->exception instanceof MissingConstructorArgumentsException => $this->getMissingArgumentsResponse($this->exception),
            $this->exception instanceof HandlerFailedException => $this->getInvalidEntityCandidateException($this->exception),
            $this->exception instanceof NotFoundHttpException => $this->getEntityNotFoundResponse(),
            default => $this->getDefaultResponse()
        };
    }

    private function getMissingArgumentsResponse(\Throwable $exception): JsonResponse
    {
        return new JsonResponse(
            [self::MESSAGE_KEY => $exception->getMessage()],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    private function getInvalidEntityCandidateException(\Throwable $exception): JsonResponse
    {
        return new JsonResponse(
            [self::MESSAGE_KEY => $exception->getPrevious()?->getMessage() ?? self::DEFAULT_MESSAGE],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    private function getEntityNotFoundResponse(): JsonResponse
    {
        return new JsonResponse('Entity not found', Response::HTTP_NOT_FOUND);
    }

    private function getDefaultResponse(): JsonResponse
    {
        return new JsonResponse(self::DEFAULT_MESSAGE, Response::HTTP_BAD_REQUEST);
    }
}
