<?php

/*
 * This file is part of a Job Portal Application Symfony Project.
 *
 * (c) Patrick Kenekayoro <Patrick.Kenekayoro@outlook.com>.
 */

namespace App\Controller\PersonalInfoActions;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\PersonalInfo;
use App\Entity\PhotoMedia;
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
    private $validator;

    public function __construct(PersonalInfoHandler $personalInfoHandler, Sec $security, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->personalInfoHandler = $personalInfoHandler;
        $this->security = $security;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/update-avatar/{id}",  name="update_avatar")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function updateAvataAction(Request $request, PersonalInfo $personal_info): Response
    {
        // or add an optional message - seen by developers
        // $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        // $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'You are not allowed to perform this action');

        $avatar = $request->files->get('avatar');
        $oldPhotoMedia = $personal_info->getAvatar();

        // Create ne newdia and set
        $photoMedia = new PhotoMedia();
        $photoMedia->file = $avatar;
        $personal_info->setAvatar($photoMedia);

        $this->validator->validate($personal_info);

        $em = $this->getDoctrine()->getManager();
        $em->persist($photoMedia);

        // delete old media
        if (null !== $oldPhotoMedia) {
            $em->remove($oldPhotoMedia);
        }
        $em->flush();

        return $this->json(['msg' => 'update successful']);
    }
}
