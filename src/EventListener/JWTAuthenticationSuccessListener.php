<?php

/*
 * This file is part of a Job Portal Application Symfony Project.
 *
 * (c) Patrick Kenekayoro <Patrick.Kenekayoro@outlook.com>.
 */

namespace App\EventListener;

use App\Repository\AppUserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTAuthenticationSuccessListener
{
    private $userRepository;

    public function __construct(AppUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['roles'] = $user->getRoles();
        $data['fullname'] = $user->getFullname();
        $data['email'] = $user->getEmail();
        $data['info'] = $user->getPersonalInfo() ? $user->getPersonalInfo()->getId() : null;

        $event->setData($data);
    }
}
