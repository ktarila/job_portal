<?php

/*
 * This file is part of a Job Portal Application Symfony Project.
 *
 * (c) Patrick Kenekayoro <Patrick.Kenekayoro@outlook.com>.
 */

namespace App\Handler;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\PersonalInfo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * This class contains methods that require database to
 * perform some operations.
 */
class PersonalInfoHandler
{
    private $entityManager;
    private $validator;
    private $csrfManager;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfManager)
    {
        $this->entityManager = $em;
        $this->validator = $validator;
        $this->csrfManager = $csrfManager;
    }

    public function create(PersonalInfo $personalInfo, $csrf = null)
    {
        $this->validator->validate($personalInfo);

        // $this->entityManager->persist($personalInfo);
        // $this->entityManager->flush();

        return $personalInfo;
    }

    public function removePersonalInfo(PersonalInfo $personalInfo, $csrf)
    {
        //dump($personalInfo);
        //dump("using custom post method");
        if ($csrf !== $this->csrfManager->getToken('form')->getValue()) {
            throw new InvalidCsrfTokenException('Invalid CSRF token');
        }

        $this->entityManager->remove($personalInfo);
        $this->entityManager->flush();

        return $personalInfo;
    }
}
