<?php

namespace App\Domain\Notificator\Generator\Mail\User;

use App\Domain\Entity\User\User;
use App\Domain\Notificator\Generator\Mail\AbstractMailGenerator;

class RegistrationMailGenerator extends AbstractMailGenerator
{
    public function send(User $user): int
    {
        $subjectId = 'registration-subject';
        $templateId = 'registration';

        $mail = $this->buildSingleMailPOPO($user, $subjectId, $templateId);

        return $this->mailShooter->send($mail);
    }
}
