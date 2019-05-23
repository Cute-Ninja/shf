<?php

namespace App\Domain\Entity\Tag;

use App\Domain\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\Tag\TagRepository")
 *
 * @UniqueEntity(fields={"name"})
 */
class Tag extends AbstractBaseEntity
{
    /**
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    protected $name;

    protected function getDefaultStatus(): string
    {
        return self::STATUS_ACTIVE;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
