<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use App\Exception\LazyLoadException;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractBaseEntity implements BaseEntityInterface
{
    public const GROUP_DEFAULT = 'default';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_DELETE = 'DELETE';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     *
     * @Serializer\Groups({AbstractBaseEntity::GROUP_DEFAULT})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50, nullable=false)
     *
     * @Serializer\Groups({AbstractBaseEntity::GROUP_DEFAULT})
     */
    protected $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    protected $createdDate;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_date", type="datetime", nullable=false)
     */
    protected $updatedDate;

    abstract protected function getDefaultStatus(): string;

    public function __construct()
    {
        $this->setStatus($this->getDefaultStatus());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCreatedDate(): \DateTime
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTime $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    public function getUpdatedDate(): \DateTime
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(\DateTime $updatedDate): void
    {
        $this->updatedDate = $updatedDate;
    }

    public function isNew(): bool
    {
        return null === $this->id;
    }

    /**
     * @param Collection $entities
     */
    protected function lazyLoadProtect(?Collection $entities): void
    {
        if ($entities instanceof PersistentCollection && false === $entities->isInitialized()) {
            throw new LazyLoadException($entities->getTypeClass()->name);
        }
    }
}
