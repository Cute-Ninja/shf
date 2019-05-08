<?php

namespace App\Domain\Repository\User;

use App\Domain\Entity\User\User;
use App\Domain\Repository\AbstractBaseRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository extends AbstractBaseRepository implements UserProviderInterface, UserLoaderInterface
{
    //###################################################################################################################
    //                                               AUTHENTICATION                                                     #
    //###################################################################################################################

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $qb = $this->createQueryBuilder('user')
            ->andWhere('user.username = :username OR user.email = :username')
            ->setParameter('username', $username)
            ->andWhere('user.status = :user_status')
            ->setParameter('user_status', User::STATUS_ACTIVE);

        $user = $qb->getQuery()->getOneOrNullResult();
        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return 'App\Domain\Entity\User' === $class;
    }
}
