<?php

namespace App\Security\Guard;

use App\Domain\Entity\User\User;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\ExpiredTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseAuthenticator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JWTTokenAuthenticator extends BaseAuthenticator
{
    /**
     * {@inheritdoc}
     *
     * @throws ExpiredTokenException
     */
    public function getUser($preAuthToken, UserProviderInterface $userProvider): UserInterface
    {
        /** @var User $user */
        $user = parent::getUser($preAuthToken, $userProvider);

        $payload = $preAuthToken->getPayload();
        if (false === password_verify($user->getPassword(), $payload['hash'])) {
            throw new ExpiredTokenException('Token is expired');
        }

        return $user;
    }
}
