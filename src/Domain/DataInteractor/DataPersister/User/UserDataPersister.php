<?php

namespace App\Domain\DataInteractor\DataPersister\User;

use App\Domain\DataInteractor\DataPersister\AbstractBaseDataPersister;
use App\Domain\Entity\User\User;
use App\Tools\Clock\ClockInterface;
use App\Tools\Clock\ClockUtils;
use App\Tools\SecurityUtils;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataPersister extends AbstractBaseDataPersister
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(
        ManagerRegistry $doctrine,
        ClockInterface $clock,
        UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($doctrine, $clock);

        $this->passwordEncoder = $passwordEncoder;
    }

    public function create(User $user, bool $sendMail = false): User
    {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $user->setConfirmationKey(SecurityUtils::randomString(15));
        $user->setConfirmationKeyExpiration(ClockUtils::createFromImmutable($this->clock->now()->modify('+1 day')));
        $user->setRoles(User::basicUserRoles());

        $this->save($user, true);

        return $user;
    }

    protected function getEntityClassName(): string
    {
        return User::class;
    }
}
