<?php

namespace App\Domain\Entity\Session;

use App\Domain\Entity\AbstractBaseEntity;
use App\Domain\Entity\Sport\Sport;
use App\Domain\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="session")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\Session\SessionRepository")
 */
class Session extends AbstractBaseEntity
{
    public const GROUP_USER = 'user';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="started_date", type="datetime", nullable=true)
     *
     * @Assert\DateTime()
     */
    protected $startedDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     *
     * @Assert\DateTime()
     */
    protected $endDate;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\User\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @Serializer\Groups({Session::GROUP_USER})
     */
    protected $user;

    /**
     * @var Sport
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Sport\Sport")
     * @ORM\JoinColumn(name="sport_id", referencedColumnName="id")
     */
    protected $sport;

    public function getStartedDate(): ?\DateTime
    {
        return $this->startedDate;
    }

    /**
     * @param \DateTime|null $startedDate
     */
    public function setStartedDate(?\DateTime $startedDate): void
    {
        $this->startedDate = $startedDate;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime|null $endDate
     */
    public function setEndDate(?\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getSport(): Sport
    {
        return $this->sport;
    }

    /**
     * @param Sport $sport
     */
    public function setSport(Sport $sport): void
    {
        $this->sport = $sport;
    }

    protected function getDefaultStatus(): string
    {
        return self::STATUS_ACTIVE;
    }
}