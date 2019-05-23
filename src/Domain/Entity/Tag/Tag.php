<?php

namespace App\Domain\Entity\Tag;

use App\Domain\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\Tag\TagRepository")
 */
class Tag extends AbstractBaseEntity
{
    /**
     * @ORM\Column(type="string", length=255)
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
