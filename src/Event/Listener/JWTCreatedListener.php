<?php

namespace App\Event\Listener;

use App\Domain\Entity\User\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     */
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        /** @var User $user */
        $user = $event->getUser();
        $data = $event->getData();

        $data['user_id'] = $user->getId();
        $data['hash'] = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $event->setData($data);
    }
}
