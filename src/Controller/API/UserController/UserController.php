<?php

namespace App\Controller\API\UserController;

use App\Controller\API\AbstractBaseController;
use App\Domain\DataInteractor\DataProvider\User\UserDataProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractBaseController
{
    /**
     * @Route(name="user_get_one", path="/user/{id}", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function getOne(Request $request, int $id, UserDataProvider $userDataProvider): Response
    {
        $user = $userDataProvider->getOneById($id);

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $user,
            $this->getSerializationGroup($request)
        );
    }
}
