<?php

namespace App\Exception;

use Throwable;

class LazyLoadException extends \RuntimeException
{
    public function __construct(string $entityName, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("$entityName as been lazy loaded. This can cause serious performance issues", $code, $previous);
    }
}
