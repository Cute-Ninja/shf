<?php

namespace App\Domain\Notification\POPO;

use App\Domain\POPO\MailRecipientPOPO;
use App\Domain\POPO\Notification\AbstractMailPOPO;

class SingleMailPOPO extends AbstractMailPOPO
{
    /**
     * @var MailRecipientPOPO
     */
    protected $recipient;

    public function getRecipient(): MailRecipientPOPO
    {
        return $this->recipient;
    }

    /**
     * @param MailRecipientPOPO $recipient
     */
    public function setRecipient(MailRecipientPOPO $recipient): void
    {
        $this->recipient = $recipient;
    }
}
