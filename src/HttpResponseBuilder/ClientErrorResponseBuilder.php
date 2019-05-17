<?php

namespace App\HttpResponseBuilder;

use App\Domain\Form\Error\ApiFormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class ClientErrorResponseBuilder extends AbstractBaseHttpResponseBuilder
{
    public function forbidden(): Response
    {
        return $this->buildResponse(null, Response::HTTP_FORBIDDEN);
    }

    public function unauthorized(): Response
    {
        return $this->buildResponse(null, Response::HTTP_UNAUTHORIZED);
    }

    public function notFound(): Response
    {
        return $this->buildResponse(null, Response::HTTP_NOT_FOUND);
    }

    public function badRequest(string $message): Response
    {
        return $this->buildResponse(['message' => $message], Response::HTTP_FORBIDDEN);
    }

    public function jsonResponseFormError(FormInterface $form): Response
    {
        $apiFormError = new ApiFormError();
        $data = $apiFormError->getFormErrorsAsFormattedArray($form);

        return $this->buildResponse($data, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
