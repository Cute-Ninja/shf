<?php

namespace App\Exception;

class UserShouldExistException extends \Exception
{
    public function __construct(int $userId)
    {
        parent::__construct("User with id $userId should exist but is not found");
    }
}
