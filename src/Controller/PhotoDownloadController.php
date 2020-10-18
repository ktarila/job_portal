<?php

/*
 * This file is part of a Job Portal Application Symfony Project.
 *
 * (c) Patrick Kenekayoro <Patrick.Kenekayoro@outlook.com>.
 */

namespace App\Controller;

use App\Entity\PhotoMedia;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\DownloadHandler;

class PhotoDownloadController extends AbstractController
{
    /**
     * @Route("/photo/media/download/{id}", name="photo_download")
     */
    public function downloadMedia(PhotoMedia $photoMedia, DownloadHandler $downloadHandler)
    {
        return $downloadHandler->downloadObject($photoMedia, $fileField = 'file');
    }
}
