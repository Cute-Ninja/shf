<?php

namespace App\Controller\API\Workout;

use App\Controller\API\AbstractBaseApiController;
use App\Domain\DataInteractor\DataProvider\Workout\WorkoutDataProvider;
use App\UseCase\Workout\GetManyWorkoutUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutController extends AbstractBaseApiController
{
    /**
     * @Route(name="workout_get_one", path="/workouts/{id}", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function getOne(Request $request, int $id, WorkoutDataProvider $workoutDataProvider): Response
    {
        $workout = $workoutDataProvider->getOneById($id);

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $workout,
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @Route(name="workout_get_many", path="/workouts", methods={"GET"})
     */
    public function getMany(Request $request, GetManyWorkoutUseCase $getManyWorkoutUseCase): Response
    {
        return $this->getSuccessResponseBuilder()->buildMultiObjectResponse(
            $getManyWorkoutUseCase->execute($request),
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @Route(name="workout_post", path="/workout/", methods={"POST"})
     */
    public function post(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @Route(name="workout_put", path="/workouts/{id}", methods={"PUT"}, requirements={"id": "\d+"})
     */
    public function put(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @Route(name="workout_patch", path="/workouts", methods={"PATCH"})
     */
    public function patch(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @Route(name="workout_delete", path="/workouts/{id}", methods={"DELETE"}, requirements={"id": "\d+"})
     */
    public function delete(): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }
}