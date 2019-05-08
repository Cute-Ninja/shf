<?php

namespace App\Domain\DataInteractor\DataProvider\Tag;

use App\Domain\DataInteractor\DataProvider\AbstractBaseDataProvider;
use App\Domain\Entity\Tag\Tag;

class TagDataProvider extends AbstractBaseDataProvider
{
    protected function getEntityClassName(): string
    {
        return Tag::class;
    }
}
