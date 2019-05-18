<?php

namespace App\Controller\API;

use App\Domain\DataInteractor\DataProvider\User\UserDataProvider;
use App\Domain\Entity\User\User;
use App\Exception\UserShouldExistException;
use App\HttpResponseBuilder\ClientErrorResponseBuilder;
use App\HttpResponseBuilder\ServerErrorResponseBuilder;
use App\HttpResponseBuilder\SuccessResponseBuilder;

abstract class AbstractUserRestrictedApiController extends AbstractBaseController
{
    /**
     * @var UserDataProvider
     */
    protected $userDataProvider;

    public function __construct(
        SuccessResponseBuilder $successResponseBuilder,
        ClientErrorResponseBuilder $clientErrorResponseBuilder,
        ServerErrorResponseBuilder $serverErrorResponseBuilder,
        UserDataProvider $userDataProvider
    ) {
        parent::__construct($successResponseBuilder, $clientErrorResponseBuilder, $serverErrorResponseBuilder);

        $this->userDataProvider = $userDataProvider;
    }

    /**
     * @throws UserShouldExistException
     */
    protected function getCurrentUser(array $selects = []): User
    {
        $userId = $this->getUser()->getId();
        $user = $this->userDataProvider->getOneById($userId, $selects);
        if (null === $user) {
            throw new UserShouldExistException($userId);
        }

        return $user;
    }
}
