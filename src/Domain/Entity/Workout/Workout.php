<?php

namespace App\Domain\Entity\Workout;

use App\Domain\Entity\AbstractBaseEntity;
use App\Registry\WorkoutStatusRegistry;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="workout")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\Workout\WorkoutRepository")
 *
 * @UniqueEntity(fields={"name"})
 */
class Workout extends AbstractBaseEntity
{
    public const GROUP_WORKOUT_STEPS = 'workoutSteps';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false, unique=true)
     *
     * @Assert\NotBlank()
     *
     * @Serializer\Groups({AbstractBaseEntity::GROUP_DEFAULT})
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     *
     * @Serializer\Groups({AbstractBaseEntity::GROUP_DEFAULT})
     */
    protected $description;

    /**
     * @var PersistentCollection|WorkoutStep[]
     *
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\Workout\WorkoutStep", mappedBy="workout")
     *
     * @Serializer\Groups({Workout::GROUP_WORKOUT_STEPS})
     */
    protected $workoutSteps;

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

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return PersistentCollection|WorkoutStep[]
     */
    public function getWorkoutSteps(): Collection
    {
        $this->lazyLoadProtect($this->workoutSteps);

        return $this->workoutSteps;
    }

    /**
     * @param WorkoutStep $workoutStep
     */
    public function addWorkoutStep(WorkoutStep $workoutStep): void
    {
        $this->workoutSteps->add($workoutStep);
    }

    /**
     * @param WorkoutStep $workoutStep
     */
    public function removeWorkoutStep(WorkoutStep $workoutStep): void
    {
        $this->workoutSteps->remove($workoutStep);
    }
}