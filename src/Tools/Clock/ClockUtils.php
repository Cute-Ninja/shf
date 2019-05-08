<?php

namespace App\Tools\Clock;

use DateTime;
use DateTimeImmutable;

class ClockUtils
{
    public static function createFromImmutable(DateTimeImmutable $datetime): DateTime
    {
        return new DateTime($datetime->format(DateTime::ATOM));
    }
}
