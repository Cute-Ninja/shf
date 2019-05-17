<?php

namespace App\Domain\DataInteractor\DataPersister\User;

use App\Domain\DataInteractor\DataPersister\AbstractBaseDataPersister;
use App\Domain\Entity\User\User;
use App\Domain\Notificator\Generator\Mail\User\RegistrationMailGenerator;
use App\Tools\Clock\ClockInterface;
use App\Tools\Clock\ClockUtils;
use App\Tools\SecurityUtils;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataPersister extends AbstractBaseDataPersister
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @var RegistrationMailGenerator */
    private $registrationMailGenerator;

    public function __construct(
        ManagerRegistry $doctrine,
        ClockInterface $clock,
        UserPasswordEncoderInterface $passwordEncoder,
        RegistrationMailGenerator $registrationMailGenerator
    ) {
        parent::__construct($doctrine, $clock);

        $this->passwordEncoder = $passwordEncoder;
        $this->registrationMailGenerator = $registrationMailGenerator;
    }

    public function create(User $user, bool $sendMail = true): User
    {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $user->setConfirmationKey(SecurityUtils::randomString(15));
        $user->setConfirmationKeyExpiration(ClockUtils::createFromImmutable($this->clock->now()->modify('+1 day')));
        $user->setRoles(User::basicUserRoles());

        $this->save($user, true);

        if (true === $sendMail) {
            $this->registrationMailGenerator->send($user);
        }

        return $user;
    }

    protected function getEntityClassName(): string
    {
        return User::class;
    }
}
