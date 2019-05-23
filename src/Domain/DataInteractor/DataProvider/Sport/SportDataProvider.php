<?php

namespace App\Domain\DataInteractor\DataProvider\Sport;

use App\Domain\DataInteractor\DataProvider\AbstractBaseDataProvider;
use App\Domain\Entity\Sport\Sport;

class SportDataProvider extends AbstractBaseDataProvider
{
    protected function getEntityClassName(): string
    {
        return Sport::class;
    }
}