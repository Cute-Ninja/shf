<?php

namespace App\Domain\DataInteractor\DataProvider;

use App\Domain\DataInteractor\AbstractBaseDataInteractor;
use App\Domain\Entity\BaseEntityInterface;
use App\Domain\Repository\AbstractBaseRepository;
use Doctrine\ORM\EntityRepository;

abstract class AbstractBaseDataProvider extends AbstractBaseDataInteractor
{
    public function getOneById(int $id, array $selects = []): ?BaseEntityInterface
    {
        return $this->getOneByCriteria(['id' => $id], $selects);
    }

    public function getOneByCriteria(array $criteria, array $selects = []): ?BaseEntityInterface
    {
        return $this->getRepository()->findOneByCriteria($criteria, $selects);
    }

    public function getManyByCriteria(array $criteria, array $selects = [], array $orders = [], ?int $limit = null, ?int $offset = null): array
    {
        return $this->getRepository()->findManyByCriteria($criteria, $selects, $orders, $limit, $offset);
    }

    /**
     * @return EntityRepository|AbstractBaseRepository
     */
    protected function getRepository(): AbstractBaseRepository
    {
        return $this->getEntityManager()->getRepository($this->getEntityClassName());
    }
}
