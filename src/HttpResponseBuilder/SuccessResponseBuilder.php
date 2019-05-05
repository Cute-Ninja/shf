<?php

namespace App\HttpResponseBuilder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SuccessResponseBuilder extends AbstractBaseHttpResponseBuilder
{
    public function buildSingleObjectResponse($object, array $serializationGroups = []): JsonResponse
    {
        if (null === $object || (is_array($object) && empty($object))) {
            $errorBuilder = new ClientErrorResponseBuilder();

            return $errorBuilder->notFound();
        }

        return $this->buildResponse($object, Response::HTTP_OK, $serializationGroups);
    }
}
