<?php

namespace App\Controller\API\Sport;

use App\Controller\API\AbstractBaseApiController;
use App\Domain\DataInteractor\DataProvider\Sport\SportDataProvider;
use App\UseCase\Sport\GetManySportUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportController extends AbstractBaseApiController
{
    /**
     * @Route(name="sport_get_one", path="/sports/{id}", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function getOne(Request $request, int $id, SportDataProvider $sportDataProvider): Response
    {
        $sport = $sportDataProvider->getOneById($id);

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $sport,
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @Route(name="sport_get_many", path="/sports", methods={"GET"})
     */
    public function getMany(Request $request, GetManySportUseCase $getManySportUseCase): Response
    {
        return $this->getSuccessResponseBuilder()->buildMultiObjectResponse(
            $getManySportUseCase->execute($request),
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @Route(name="sport_post", path="/sport/", methods={"POST"})
     */
    public function post(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @Route(name="sport_put", path="/sports/{id}", methods={"PUT"}, requirements={"id": "\d+"})
     */
    public function put(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @Route(name="sport_patch", path="/sports", methods={"PATCH"})
     */
    public function patch(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @Route(name="sport_delete", path="/sports/{id}", methods={"DELETE"}, requirements={"id": "\d+"})
     */
    public function delete(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }
}