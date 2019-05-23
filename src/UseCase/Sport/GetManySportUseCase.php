<?php

namespace App\UseCase\Sport;

use App\Domain\DataInteractor\DataProvider\Sport\SportDataProvider;
use App\UseCase\AbstractBaseUseCase;
use Symfony\Component\HttpFoundation\Request;

class GetManySportUseCase extends AbstractBaseUseCase
{
    public function __construct(SportDataProvider $sportDataProvider)
    {
        $this->dataProvider = $sportDataProvider;
    }

    protected function buildCriteria(Request $request): array
    {
        return [];
    }

    public function getAllowedSelects(): array
    {
        return ['parent'];
    }
}