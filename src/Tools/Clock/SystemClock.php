<?php

namespace App\Tools\Clock;

use DateTimeImmutable;
use DateTimeZone;

class SystemClock implements ClockInterface
{
    /**
     * @var DateTimeZone
     */
    private $timezone;

    public function __construct(DateTimeZone $timezone = null)
    {
        $this->timezone = $timezone ?: new DateTimeZone(date_default_timezone_get());
    }

    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now', $this->timezone);
    }
}
