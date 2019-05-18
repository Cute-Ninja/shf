<?php

namespace App\Domain\Notificator\Generator\Mail;

use App\Domain\Entity\User\User;
use App\Domain\Notification\POPO\SingleMailPOPO;
use App\Domain\Notificator\Sender\Mail\MailShooter;
use App\Domain\POPO\MailRecipientPOPO;
use App\Domain\POPO\MailSenderPOPO;
use App\Domain\POPO\Notification\BatchMailPOPO;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractMailGenerator
{
    /** @var TranslatorInterface */
    protected $translator;

    /** @var EngineInterface */
    protected $twig;

    /** @var MailShooter */
    protected $mailShooter;

    /** @var string */
    protected $senderMail;

    /** @var string */
    protected $senderName;

    public function __construct(
        TranslatorInterface $translator,
        EngineInterface $twig,
        MailShooter $mailShooter,
        string $senderMail,
        string $senderName
    ) {
        $this->translator = $translator;
        $this->twig = $twig;
        $this->senderMail = $senderMail;
        $this->senderName = $senderName;
    }

    protected function buildSingleMailPOPO(User $user, string $subjectId, string $templateId, array $attributes = []): SingleMailPOPO
    {
        $mail = new SingleMailPOPO();
        $mail->setSubject($this->translator->trans($subjectId, $attributes, 'email'));
        $mail->setTemplate($this->twig->render($templateId, $attributes));
        $mail->setSender($this->buildSender());
        $mail->setRecipient($this->buildRecipient($user));

        return $mail;
    }

    protected function buildBatchMailPOPO(array $users, string $subjectId, string $templateId, array $attributes = []): BatchMailPOPO
    {
        $mail = new BatchMailPOPO();
        $mail->setSubject($this->translator->trans($subjectId, $attributes, 'email'));
        $mail->setTemplate($this->twig->render($templateId, $attributes));
        $mail->setSender($this->buildSender());
        $mail->setRecipients($this->buildRecipients($users));

        return $mail;
    }

    private function buildRecipient(User $user): MailRecipientPOPO
    {
        $recipient = new MailRecipientPOPO();

        $recipient->setUserId($user->getId());
        $recipient->setName($user->getUsername());
        $recipient->setEmail($user->getEmail());
        $recipient->setAttributes([]);

        return $recipient;
    }

    /**
     * @param User[] $users
     *
     * @return MailRecipientPOPO[]
     */
    private function buildRecipients(array $users): array
    {
        $recipients = [];
        foreach ($users as $user) {
            $recipients[] = $this->buildRecipient($user);
        }

        return $recipients;
    }

    private function buildSender(): MailSenderPOPO
    {
        $sender = new MailSenderPOPO();

        $sender->setName($this->senderName);
        $sender->setEmail($this->senderMail);

        return $sender;
    }
}
