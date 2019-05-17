<?php

namespace App\Controller\API\UserController;

use App\Controller\API\AbstractUserRestrictedApiController;
use App\Domain\DataInteractor\DataPersister\User\UserDataPersister;
use App\Domain\DataInteractor\DataProvider\User\UserDataProvider;
use App\Domain\Entity\User\User;
use App\Domain\Form\Type\User\UserFormType;
use App\Exception\UserShouldExistException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractUserRestrictedApiController
{
    /**
     * @Route(name="user_get_one", path="/users/{id}", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function getOne(Request $request, int $id, UserDataProvider $userDataProvider): Response
    {
        $user = $userDataProvider->getOneById($id);

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $user,
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @Route(name="user_get_many", path="/users", methods={"GET"})
     */
    public function getMany(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @Route(name="user_post", path="/user/", methods={"POST"})
     */
    public function post(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @Route(name="user_put", path="/users/{id}", methods={"PUT"}, requirements={"id": "\d+"})
     */
    public function put(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @Route(name="user_patch", path="/users", methods={"PATCH"})
     */
    public function patch(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @Route(name="user_delete", path="/users/{id}", methods={"DELETE"}, requirements={"id": "\d+"})
     */
    public function delete(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /*******************************************************************************************************************
     *                                                  PROXIES
     ******************************************************************************************************************/

    /**
     * @Route(name="user_get_me", path="/users/me", methods={"GET"})
     *
     * @throws UserShouldExistException
     */
    public function getMe(Request $request): Response
    {
        $user = $this->getCurrentUser($request);

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse($user, ['userStats']);
    }

    /**
     * @Route(name="user_post_registration", path="/users/registration", methods={"POST"})
     */
    public function registration(Request $request, UserDataPersister $userDataPersister): Response
    {
        if (null !== $request->headers->get('Authorization')) {
            return $this->getClientErrorResponseBuilder()->forbidden();
        }

        $user = new User();
        $form = $this->createForm(
            UserFormType::class,
            $user,
            ['method' => 'POST', 'context' => UserFormType::CONTEXT_CREATE, 'validation_groups' => 'registration']
        );
        $form->handleRequest($request);

        if (false === $form->isSubmitted() || false === $form->isValid()) {
            return $this->getClientErrorResponseBuilder()->jsonResponseFormError($form);
        }

        $userDataPersister->create($user);

        return $this->getSuccessResponseBuilder()->created($user, $this->getSerializationGroup($request));
    }
}
