<?php

namespace App\Domain\Repository;

use App\Domain\Entity\AbstractBaseEntity;
use App\Tools\StringUtils;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractBaseRepository extends EntityRepository
{
    protected const ORDER_DIRECTION_ASC = 'ASC';
    protected const ORDER_DIRECTION_DESC = 'DESC';

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder($this->getAlias())
            ->select('DISTINCT '.$this->getAlias());
    }

    public function findOneByCriteria(array $criteria = [], array $selects = []): ?AbstractBaseEntity
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $criteria)
            ->addSelects($queryBuilder, $this->addDefaultSelect($selects));
        $this->cleanQueryBuilder($queryBuilder);
        try {
            return $queryBuilder->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $exception) {
            return null;
        }
    }

    public function findManyByCriteriaBuilder(array $criteria = [], array $selects = [], array $orders = []): QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $criteria)
            ->addOrderBys($queryBuilder, $orders)
            ->addSelects($queryBuilder, $this->addDefaultSelect($selects));
        $this->cleanQueryBuilder($queryBuilder);

        return $queryBuilder;
    }

    /**
     * @param array    $criteria
     * @param array    $selects
     * @param array    $orders
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return AbstractBaseRepository[]
     */
    public function findManyByCriteria(array $criteria = [], array $selects = [], array $orders = [], ?int $limit = null, ?int $offset = null): array
    {
        $queryBuilder = $this->findManyByCriteriaBuilder($criteria, $selects, $orders);
        if (null !== $limit) {
            $queryBuilder->setMaxResults($limit);
        }
        if (null !== $offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    protected function addCriteria(QueryBuilder $queryBuilder, array $criteria = []): AbstractBaseRepository
    {
        foreach ($criteria as $field => $value) {
            if ($field) {
                $this->{'addCriterion'.ucfirst($field)}($queryBuilder, $value);
            }
        }

        return $this;
    }

    protected function getAlias(): string
    {
        return StringUtils::toSnakeCase($this->getClassName());
    }

    protected function computeAlias(string $alias = null): string
    {
        return $alias ?? $this->getAlias();
    }

    /**
     * @param QueryBuilder    $queryBuilder
     * @param null|int|int|[] $id
     *
     * @return bool
     */
    protected function addCriterionId(QueryBuilder $queryBuilder, $id): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'id', $id);
    }

    /**
     * @param QueryBuilder         $queryBuilder
     * @param string|string[]|null $status
     *
     * @return bool
     */
    protected function addCriterionStatus(QueryBuilder $queryBuilder, $status): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'status', $status);
    }

    protected function addCriterion(QueryBuilder $queryBuilder, string $alias, string $fieldName, $value, bool $exclude = false): bool
    {
        [$condition, $parameter, $value] = $this->computeCriterionCondition($alias, $fieldName, $value, $exclude);
        if (null === $condition) {
            return false;
        }
        $queryBuilder->andWhere($condition);
        if (null !== $parameter) {
            $queryBuilder->setParameter($parameter, $value);
        }

        return true;
    }

    protected function addCriterionLike(QueryBuilder $queryBuilder, string $alias, string $fieldName, string $value): bool
    {
        if (null === $value) {
            return false;
        }
        $parameter = $alias.'_'.$fieldName;
        $value = '%'.$value.'%';
        $queryBuilder->andWhere("$alias.$fieldName LIKE :".$parameter);
        $queryBuilder->setParameter($parameter, $value);

        return true;
    }

    protected function addOrderBys(QueryBuilder $queryBuilder, array $orderBys = []): AbstractBaseRepository
    {
        foreach ($orderBys as $orderBy => $direction) {
            if ($orderBy) {
                $this->{'addOrderBy'.ucfirst($orderBy)}($queryBuilder, $direction);
            }
        }

        return $this;
    }

    protected function addOrderBy(QueryBuilder $queryBuilder, string $alias, string $fieldName, string $direction): void
    {
        if (false === in_array($direction, [self::ORDER_DIRECTION_DESC, self::ORDER_DIRECTION_ASC], true)) {
            throw new \LogicException("$direction is not a valid value for order by 'direction' parameter.");
        }
        $queryBuilder->addOrderBy($alias.'.'.$fieldName, $direction);
    }

    protected function addSelects(QueryBuilder $queryBuilder, array $selects = []): AbstractBaseRepository
    {
        foreach ($selects as $select) {
            if ($select) {
                $this->{'addSelect'.ucfirst($select)}($queryBuilder);
            }
        }

        return $this;
    }

    protected function getDefaultSelects(): array
    {
        return [];
    }

    private function cleanQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder
    {
        $this->cleanQueryBuilderDqlPart($queryBuilder, 'join');
        $this->cleanQueryBuilderDqlPart($queryBuilder, 'select');

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $dqlPartName  ('join', 'select', ...)
     */
    private function cleanQueryBuilderDqlPart(QueryBuilder $queryBuilder, string $dqlPartName): void
    {
        $dqlPart = $queryBuilder->getDQLPart($dqlPartName);
        $newDqlPart = [];
        if (0 === count($dqlPart)) {
            return;
        }
        $queryBuilder->resetDQLPart($dqlPartName);
        if ('join' === $dqlPartName) {
            $this->cleanJoinFromQuery($queryBuilder, $dqlPart, $dqlPartName, $newDqlPart);

            return;
        }
        foreach ($dqlPart as $element) {
            $newDqlPart[$element->__toString()] = $element;
        }
        $dqlPart = array_values($newDqlPart);
        foreach ($dqlPart as $element) {
            $queryBuilder->add($dqlPartName, $element, true);
        }
    }

    private function cleanJoinFromQuery(QueryBuilder $queryBuilder, $dqlPart, string $dqlPartName, array $newDqlPart): void
    {
        foreach ($dqlPart as $root => $elements) {
            foreach ($elements as $element) {
                preg_match(
                    '/^(?P<joinType>[^ ]+) JOIN (?P<join>[^ ]+) (?P<alias>[^ ]+)/',
                    $element->__toString(),
                    $matches
                );
                if (false === array_key_exists($matches['alias'], $newDqlPart)) {
                    $newDqlPart[$matches['alias']] = $element;
                }
            }
            $dqlPart[$root] = array_values($newDqlPart);
        }
        $dqlPart = array_shift($dqlPart);
        foreach ($dqlPart as $element) {
            $queryBuilder->add($dqlPartName, [$element], true);
        }
    }

    private function computeCriterionCondition(string $alias, string $fieldName, $value, bool $exclude = false): array
    {
        if (null === $value) {
            return [null, null, null];
        }
        $operator = $exclude ? '!=' : '=';
        $condition = $alias.'.'.$fieldName.' '.$operator.' :'.$alias.'_'.$fieldName;
        $parameterField = $alias.'_'.$fieldName;
        $parameterValue = false !== $value && empty($value) ? null : $value;
        if (is_array($value)) {
            $operator = $exclude ? 'NOT IN' : 'IN';
            $condition = $alias.'.'.$fieldName.' '.$operator.' (:'.$alias.'_'.$fieldName.')';
        } elseif ('NULL' === $value) {
            $condition = $alias.'.'.$fieldName.' IS NULL';
            $parameterField = null;
            $parameterValue = null;
        } elseif ('NOT NULL' === $value) {
            $condition = $alias.'.'.$fieldName.' IS NOT NULL';
            $parameterField = null;
            $parameterValue = null;
        }

        return [$condition, $parameterField, $parameterValue];
    }

    private function addDefaultSelect(array $selects = []): array
    {
        return array_merge($selects, $this->getDefaultSelects());
    }
}
