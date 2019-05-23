<?php

namespace App\UseCase\Workout;

use App\Domain\DataInteractor\DataProvider\Workout\WorkoutDataProvider;
use App\Domain\Entity\Workout\Workout;
use App\Registry\WorkoutStatusRegistry;
use App\UseCase\AbstractBaseUseCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Workout[] execute(Request $request)
 */
class GetManyWorkoutUseCase extends AbstractBaseUseCase
{
    public function __construct(WorkoutDataProvider $workoutDataProvider)
    {
        $this->dataProvider = $workoutDataProvider;
    }

    protected function buildCriteria(Request $request): array
    {
        return [
            'status' => $request->get('status', WorkoutStatusRegistry::STATUS_ACTIVE)
        ];
    }

    public function getAllowedSelects(): array
    {
        return [Workout::GROUP_WORKOUT_STEPS];
    }
}