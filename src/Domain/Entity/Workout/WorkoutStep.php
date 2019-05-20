<?php

namespace App\Domain\Entity\Workout;

use App\Domain\Entity\AbstractBaseEntity;
use App\Registry\WorkoutStatusRegistry;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="workout_step")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\Workout\WorkoutStepRepository")
 *
 * @UniqueEntity(fields={"name"})
 */
class WorkoutStep extends AbstractBaseEntity
{
    public const GROUP_WORKOUT = 'workout';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     *
     * @Assert\NotBlank()
     *
     * @Serializer\Groups({AbstractBaseEntity::GROUP_DEFAULT})
     */
    protected $name;

    /**
     * @var Workout
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Workout\Workout", inversedBy="workoutSteps")
     * @ORM\JoinColumn(name="workout_id", referencedColumnName="id")
     *
     * @Serializer\Groups({WorkoutStep::GROUP_WORKOUT})
     */
    protected $workout;

    protected function getDefaultStatus(): string
    {
        return WorkoutStatusRegistry::STATUS_DRAFT;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getWorkout(): Workout
    {
        return $this->workout;
    }

    /**
     * @param Workout $workout
     */
    public function setWorkout(Workout $workout): void
    {
        $this->workout = $workout;
    }
}