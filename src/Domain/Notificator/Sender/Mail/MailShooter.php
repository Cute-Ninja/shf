<?php

namespace App\Domain\Notificator\Sender\Mail;

use App\Domain\Notification\POPO\SingleMailPOPO;
use App\Domain\POPO\MailRecipientPOPO;
use App\Domain\POPO\MailSenderPOPO;
use App\Domain\POPO\Notification\AbstractMailPOPO;
use App\Domain\POPO\Notification\BatchMailPOPO;

class MailShooter
{
    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(AbstractMailPOPO $mail): int
    {
        $subject = $mail->getSubject();
        $template = $mail->getTemplate();
        $formattedSender = $this->formatSender($mail->getSender());

        $sent = 0;
        if ($mail instanceof SingleMailPOPO) {
            $sent = $this->doUnitSend($subject, $template, $formattedSender, $this->formatRecipient($mail->getRecipient()));
        } elseif ($mail instanceof BatchMailPOPO) {
            foreach ($mail->getRecipients() as $recipient) {
                $sent += $this->doUnitSend($subject, $template, $formattedSender, $this->formatRecipient($recipient));
            }
        }

        return $sent;
    }

    protected function doUnitSend(string $subject, string $template, string $formattedSender, string $formattedRecipient): int
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($formattedSender)
            ->setTo($formattedRecipient)
            ->setBody($template, 'text/html');

        return $this->mailer->send($message);
    }

    protected function formatSender(MailSenderPOPO $sender): string
    {
        return $sender->getEmail();
    }

    protected function formatRecipient(MailRecipientPOPO $recipient): string
    {
        return $recipient->getEmail();
    }
}
