<?php

/*
 * This file is part of a Job Portal Application Symfony Project.
 *
 * (c) Patrick Kenekayoro <Patrick.Kenekayoro@outlook.com>.
 */

namespace App\Controller\PersonalInfoActions;

use App\Entity\PersonalInfo;
use App\Handler\PersonalInfoHandler;

class CreatePersonalInfo
{
    private $personalInfoHandler;

    public function __construct(PersonalInfoHandler $personalInfoHandler)
    {
        $this->personalInfoHandler = $personalInfoHandler;
    }

    public function __invoke(PersonalInfo $data): PersonalInfo
    {
        dump($data);
        $this->personalInfoHandler->create($data);

        return $data;
    }
}
