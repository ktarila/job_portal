<?php

/*
 * This file is part of a Job Portal Application Symfony Project.
 *
 * (c) Patrick Kenekayoro <Patrick.Kenekayoro@outlook.com>.
 */

namespace App\Controller\PersonalInfoActions;

use App\Entity\PersonalInfo;
use App\Entity\PhotoMedia;
use App\Handler\PersonalInfoHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

class CreatePersonalInfo
{
    private $personalInfoHandler;
    private $security;
    private $serializer;

    public function __construct(PersonalInfoHandler $personalInfoHandler, Security $security, SerializerInterface $serializer)
    {
        $this->personalInfoHandler = $personalInfoHandler;
        $this->security = $security;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): PersonalInfo
    {
        $user = $this->security->getUser();
        $formData = $request->request->all();
        $json_data = json_encode($formData);
        // dump($json_data);
        $data = $this->serializer->deserialize($json_data, PersonalInfo::class, 'json', ['groups' => ['write']]);
        // dump($data);
        $avatar = $request->files->get('avatar');
        // $data = $this->createObject($formData);
        $data->setUserAccount($user);

        $photoMedia = new PhotoMedia();
        $photoMedia->file = $avatar;
        $data->setAvatar($photoMedia);

        $this->personalInfoHandler->create($data);

        return $data;
    }
}
