<?php

namespace App\Domain\POPO\Notification;

class AbstractNotificationPOPO
{
    /** @var string */
    protected $template;

    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }
}
