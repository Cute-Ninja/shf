<?php

namespace App\UseCase\Workout;

use App\Domain\DataInteractor\DataProvider\Workout\WorkoutDataProvider;
use App\Domain\Entity\Workout\Workout;
use App\Registry\WorkoutStatusRegistry;
use App\UseCase\AbstractBaseUseCase;
use Symfony\Component\HttpFoundation\Request;

class GetManyWorkoutUseCase extends AbstractBaseUseCase
{
    /** @var WorkoutDataProvider */
    private $workoutDataProvider;

    public function __construct(WorkoutDataProvider $workoutDataProvider)
    {
        $this->workoutDataProvider = $workoutDataProvider;
    }

    /**
     * @param Request $request
     *
     * @return Workout[]
     */
    public function execute(Request $request): array
    {
        return $this->workoutDataProvider->getManyByCriteria(
            $this->buildCriteria($request),
            $this->buildSelects($request)
        );
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