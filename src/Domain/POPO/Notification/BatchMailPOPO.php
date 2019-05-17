<?php

namespace App\Domain\POPO\Notification;

use App\Domain\POPO\MailRecipientPOPO;

class BatchMailPOPO extends AbstractMailPOPO
{
    /**
     * @var MailRecipientPOPO[]
     */
    protected $recipients;

    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @param MailRecipientPOPO[] $recipient
     */
    public function setRecipients(array $recipients): void
    {
        $this->recipients = $recipients;
    }
}