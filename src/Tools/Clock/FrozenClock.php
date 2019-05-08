<?php

namespace App\Tools\Clock;

use DateTimeImmutable;

class FrozenClock implements ClockInterface
{
    /**
     * @var DateTimeImmutable
     */
    private $now;

    public function __construct(DateTimeImmutable $now)
    {
        $this->now = $now;
    }

    public function setTo(DateTimeImmutable $now): void
    {
        $this->now = $now;
    }

    public function now(): DateTimeImmutable
    {
        return $this->now;
    }
}
