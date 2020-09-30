<?php

/*
 * This file is part of a Job Portal Application Symfony Project.
 *
 * (c) Patrick Kenekayoro <Patrick.Kenekayoro@outlook.com>.
 */

namespace App\Controller\PersonalInfoActions;

use App\Entity\PersonalInfo;
use App\Handler\PersonalInfoHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class CreatePersonalInfo
{
    private $personalInfoHandler;
    private $security;

    public function __construct(PersonalInfoHandler $personalInfoHandler, Security $security)
    {
        $this->personalInfoHandler = $personalInfoHandler;
        $this->security = $security;
    }

    public function __invoke(Request $request): PersonalInfo
    {
        $user = $this->security->getUser();
        $formData = $request->request->all();
        $data = $this->createObject($formData);
        $data->setUserAccount($user);
        $this->personalInfoHandler->create($data);

        return $data;
    }

    public function createObject($data): PersonalInfo
    {
        $info = new PersonalInfo();
        if (isset($data['firstname'])) {
            $info->setFirstname($data['firstname']);
        }

        if (isset($data['middlename'])) {
            $info->setMiddlename($data['middlename']);
        }

        if (isset($data['lastname'])) {
            $info->setLastname($data['lastname']);
        }

        return $info;
    }
}
