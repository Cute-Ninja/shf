<?php

namespace App\HttpResponseBuilder;

use Symfony\Component\HttpFoundation\Response;

class ServerErrorResponseBuilder extends AbstractBaseHttpResponseBuilder
{
    public function exception(\Exception $e): Response
    {
        $code = $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR;
        $message = $e->getMessage() ?: null;

        return $this->buildResponse(['message' => $message], $code);
    }

    public function notImplemented(): Response
    {
        return $this->buildResponse(null, Response::HTTP_NOT_IMPLEMENTED);
    }
}
