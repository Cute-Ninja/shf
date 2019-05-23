<?php

namespace App\Domain\Entity\Sport;

use App\Domain\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="sport")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\Sport\SportRepository")
 *
 * @UniqueEntity(fields={"name"})
 */
class Sport extends AbstractBaseEntity
{
    public const GROUP_SPORT_PARENT = 'parent_sport';

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
     * @var Sport|null
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Sport\Sport")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     *
     * @Serializer\Groups({Sport::GROUP_SPORT_PARENT})
     */
    protected $parent;

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

    public function getParent(): ?Sport
    {
        return $this->parent;
    }

    /**
     * @param Sport|null $parent
     */
    public function setParent(?Sport $parent): void
    {
        $this->parent = $parent;
    }

    protected function getDefaultStatus(): string
    {
        return self::STATUS_ACTIVE;
    }
}