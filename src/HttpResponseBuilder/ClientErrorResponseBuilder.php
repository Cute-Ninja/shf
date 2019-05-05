<?php

namespace App\HttpResponseBuilder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ClientErrorResponseBuilder extends AbstractBaseHttpResponseBuilder
{
    public function forbidden(): JsonResponse
    {
        return $this->buildResponse(null, Response::HTTP_FORBIDDEN);
    }

    public function unauthorized(): JsonResponse
    {
        return $this->buildResponse(null, Response::HTTP_UNAUTHORIZED);
    }

    public function notFound(): JsonResponse
    {
        return $this->buildResponse(null, Response::HTTP_NOT_FOUND);
    }

    public function badRequest(string $message): JsonResponse
    {
        return $this->buildResponse(['message' => $message], Response::HTTP_FORBIDDEN);
    }
}
