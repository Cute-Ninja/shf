<?php

namespace App\HttpResponseBuilder;

use Symfony\Component\HttpFoundation\Response;

class SuccessResponseBuilder extends AbstractBaseHttpResponseBuilder
{
    public function buildSingleObjectResponse($object, array $serializationGroups = []): Response
    {
        if (null === $object || (is_array($object) && empty($object))) {
            $errorBuilder = new ClientErrorResponseBuilder($this->twig);

            return $errorBuilder->notFound();
        }

        return $this->buildResponse($object, Response::HTTP_OK, $serializationGroups);
    }

    public function buildMultiObjectResponse(array $objects, array $serializationGroups = []): Response
    {
        if (true === empty($objects)) {
            return $this->buildResponse(null, Response::HTTP_NO_CONTENT);
        }

        return $this->buildResponse($objects, Response::HTTP_OK, $serializationGroups);
    }

    public function created($object, array $serializationGroups = []): Response
    {
        return $this->buildResponse($object, Response::HTTP_CREATED, $serializationGroups);
    }
}
