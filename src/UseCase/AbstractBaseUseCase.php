<?php

namespace App\UseCase;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractBaseUseCase
{
    abstract public function getAllowedSelects(): array;

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