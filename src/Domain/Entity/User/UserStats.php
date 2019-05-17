<?php

namespace App\Domain\Entity\User;

use App\Domain\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="user_stats")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\User\UserStatsRepository")
 *
 * @UniqueEntity(fields={"user"})
 */
class UserStats extends AbstractBaseEntity
{
    /**
     * @var float
     *
     * @ORM\Column(name="distance_total", type="float", nullable=false)
     *
     * @Serializer\Groups({"default"})
     */
    protected $distanceTotal = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="distance_of_the_week", type="float", nullable=false)
     *
     * @Serializer\Groups({"default"})
     */
    protected $distanceOfTheWeek = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="calories_total", type="integer", nullable=false)
     *
     * @Serializer\Groups({"default"})
     */
    protected $caloriesTotal = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="calories_of_the_week", type="integer", nullable=false)
     *
     * @Serializer\Groups({"default"})
     */
    protected $caloriesOfTheWeek = 0;

    public function getDistanceTotal(): float
    {
        return $this->distanceTotal;
    }

    public function setDistanceTotal(float $distanceTotal): void
    {
        $this->distanceTotal = $distanceTotal;
    }

    public function getDistanceOfTheWeek(): float
    {
        return $this->distanceOfTheWeek;
    }

    public function setDistanceOfTheWeek(float $distanceOfTheWeek): void
    {
        $this->distanceOfTheWeek = $distanceOfTheWeek;
    }

    public function getCaloriesTotal(): int
    {
        return $this->caloriesTotal;
    }

    public function setCaloriesTotal(int $caloriesTotal): void
    {
        $this->caloriesTotal = $caloriesTotal;
    }

    public function getCaloriesOfTheWeek(): int
    {
        return $this->caloriesOfTheWeek;
    }

    public function setCaloriesOfTheWeek(int $caloriesOfTheWeek): void
    {
        $this->caloriesOfTheWeek = $caloriesOfTheWeek;
    }

    protected function getDefaultStatus(): string
    {
        return self::STATUS_ACTIVE;
    }
}
