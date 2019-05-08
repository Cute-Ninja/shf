<?php

namespace App\Tools;

class SecurityUtils
{
    public static function randomString(?int $length = 10): string
    {
        return bin2hex(random_bytes($length));
    }
}
