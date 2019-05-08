<?php

namespace App\Domain\DataInteractor\DataProvider\User;

use App\Domain\DataInteractor\DataProvider\AbstractBaseDataProvider;
use App\Domain\Entity\User\User;

/**
 * @method User   getOneById(int $id, array $selects = [])
 * @method User   getOneByCriteria(array $criteria, array $selects = [])
 * @method User[] getManyByCriteria(array $criteria, array $selects = [], array $orders = [], ?int $limit = null, ?int $offset = null) : array
 */
class UserDataProvider extends AbstractBaseDataProvider
{
    protected function getEntityClassName(): string
    {
        return User::class;
    }
}
