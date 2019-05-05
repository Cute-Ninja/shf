<?php

namespace App\Domain\DataInteractor;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

abstract class AbstractBaseDataInteractor
{
    protected const ENTITY_MANAGER_DEFAULT = 'default';

    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    abstract protected function getEntityClassName(): string;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param string $managerName
     *
     * @return ObjectManager|EntityManager
     */
    protected function getEntityManager(?string $managerName = null): EntityManager
    {
        return $this->doctrine->getManager($managerName ?? self::ENTITY_MANAGER_DEFAULT);
    }
}
