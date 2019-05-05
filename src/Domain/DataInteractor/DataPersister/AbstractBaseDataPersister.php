<?php

namespace App\Domain\DataInteractor\DataPersister;

use App\Domain\DataInteractor\AbstractBaseDataInteractor;
use App\Domain\Entity\BaseEntityInterface;

abstract class AbstractBaseDataPersister extends AbstractBaseDataInteractor
{
    public function save(BaseEntityInterface $entity, bool $flush = false): BaseEntityInterface
    {
        if (true === $entity->isNew()) {
            $this->getEntityManager()->persist($entity);
        }

        if (true === $flush) {
            $this->getEntityManager()->flush();
        }

        return $entity;
    }

    /**
     * @param BaseEntityInterface[] $entities
     * @param bool                  $flush
     *
     * @return array
     */
    public function saveList(array $entities, bool $flush = false): array
    {
        foreach ($entities as $entity) {
            $this->save($entity, $flush);
        }

        return $entities;
    }

    public function remove(BaseEntityInterface $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        if (true === $flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param BaseEntityInterface[] $entities
     * @param bool                  $flush
     */
    public function removeList(array $entities, bool $flush = false): void
    {
        foreach ($entities as $entity) {
            $this->remove($entity, $flush);
        }
    }
}
