<?php

namespace App\Controller\API;

use App\Domain\Entity\AbstractBaseEntity;
use App\HttpResponseBuilder\ClientErrorResponseBuilder;
use App\HttpResponseBuilder\ServerErrorResponseBuilder;
use App\HttpResponseBuilder\SuccessResponseBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractBaseApiController extends AbstractController
{
    /** @var SuccessResponseBuilder */
    private $successResponseBuilder;

    /** @var ClientErrorResponseBuilder */
    private $clientErrorResponseBuilder;

    /** @var ServerErrorResponseBuilder */
    private $serverErrorResponseBuilder;

    public function __construct(
        SuccessResponseBuilder $successResponseBuilder,
        ClientErrorResponseBuilder $clientErrorResponseBuilder,
        ServerErrorResponseBuilder $serverErrorResponseBuilder
    ) {
        $this->successResponseBuilder = $successResponseBuilder;
        $this->clientErrorResponseBuilder = $clientErrorResponseBuilder;
        $this->serverErrorResponseBuilder = $serverErrorResponseBuilder;
    }

    protected function getSerializationGroup(Request $request): array
    {
        $requestGroups = $request->get('groups');
        $groups = explode(',', $requestGroups);
        if ('test' !== $requestGroups) {
            $groups[] = AbstractBaseEntity::GROUP_DEFAULT;
        }

        return $groups;
    }

    protected function getSuccessResponseBuilder(): SuccessResponseBuilder
    {
        return $this->successResponseBuilder;
    }

    protected function getClientErrorResponseBuilder(): ClientErrorResponseBuilder
    {
        return $this->clientErrorResponseBuilder;
    }

    protected function getServerErrorResponseBuilder(): ServerErrorResponseBuilder
    {
        return $this->serverErrorResponseBuilder;
    }
}
