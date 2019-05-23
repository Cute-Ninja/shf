<?php

namespace App\UseCase;

use App\Domain\DataInteractor\DataProvider\AbstractBaseDataProvider;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractBaseUseCase
{
    /** @var AbstractBaseDataProvider */
    protected $dataProvider;

    abstract public function getAllowedSelects(): array;

    abstract protected function buildCriteria(Request $request): array;

    public function execute(Request $request): array
    {
        return $this->dataProvider->getManyByCriteria(
            $this->buildCriteria($request),
            $this->buildSelects($request)
        );
    }
    protected function buildSelects(Request $request): array
    {
        $selects = [];

        $groups = explode(',', $request->get('groups'));
        foreach ($groups as $group) {
            if (true === in_array($group, $this->getAllowedSelects())) {
                $selects[] = $group;
            }
        }

        return $selects;
    }
}