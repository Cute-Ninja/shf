<?php

namespace App\Domain\Entity\User;

use App\Domain\Entity\AbstractBaseEntity;

class UserStats extends AbstractBaseEntity
{
    protected function getDefaultStatus(): string
    {
        return self::STATUS_ACTIVE;
    }
}
