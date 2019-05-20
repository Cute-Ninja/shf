<?php

namespace App\Domain\DataInteractor\DataProvider\Workout;

use App\Domain\DataInteractor\DataProvider\AbstractBaseDataProvider;
use App\Domain\Entity\Workout\Workout;

class WorkoutDataProvider extends AbstractBaseDataProvider
{
    protected function getEntityClassName(): string
    {
        return Workout::class;
    }
}