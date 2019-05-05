<?php

namespace App\Domain\DataInteractor\DataProvider\User;

use App\Domain\DataInteractor\DataProvider\AbstractBaseDataProvider;
use App\Domain\Entity\User\User;

class UserDataProvider extends AbstractBaseDataProvider
{
    protected function getEntityClassName(): string
    {
        return User::class;
    }
}
