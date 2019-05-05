<?php

namespace App\Domain\Entity\User;

use App\Domain\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\User\UserRepository")
 */
class User extends AbstractBaseEntity
{
    public const STATUS_TO_ACTIVATE = 'to-activate';

    protected function getDefaultStatus(): string
    {
        return self::STATUS_TO_ACTIVATE;
    }
}
