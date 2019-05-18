<?php

namespace App\Domain\POPO\Notification;

use App\Domain\POPO\MailSenderPOPO;

class AbstractMailPOPO extends AbstractNotificationPOPO
{
    /** @var string */
    protected $subject;

    /** @var MailSenderPOPO */
    protected $sender;

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getSender(): MailSenderPOPO
    {
        return $this->sender;
    }

    /**
     * @param MailSenderPOPO $sender
     */
    public function setSender(MailSenderPOPO $sender): void
    {
        $this->sender = $sender;
    }
}
