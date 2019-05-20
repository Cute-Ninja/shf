<?php

namespace App\Domain\Repository\Workout;

use App\Domain\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

class WorkoutRepository extends AbstractBaseRepository
{
    //###################################################################################################################
    //                                                   SELECT                                                         #
    //###################################################################################################################

    public function addSelectWorkoutSteps(QueryBuilder $queryBuilder, string $alias = null): void
    {
        $queryBuilder->leftJoin($this->computeAlias($alias).'.workoutSteps', 'workout_step');
        $queryBuilder->addSelect('workout_step');
    }
}