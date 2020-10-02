<?php

/*
 * This file is part of a Job Portal Application Symfony Project.
 *
 * (c) Patrick Kenekayoro <Patrick.Kenekayoro@outlook.com>.
 */

namespace App\Controller\PersonalInfoActions;

use App\Entity\PersonalInfo;
use App\Handler\PersonalInfoHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as Sec;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/personal_info")
 */
class PersonalInfoController extends AbstractController
{
    private $personalInfoHandler;
    private $security;
    private $serializer;

    public function __construct(PersonalInfoHandler $personalInfoHandler, Sec $security, SerializerInterface $serializer)
    {
        $this->personalInfoHandler = $personalInfoHandler;
        $this->security = $security;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/update-avatar/{id}",  name="update_avatar")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function updateAvataAction(Request $request, PersonalInfo $personal_info): Response
    {
        return $this->json(['msg' => 'update successful']);
    }
}
