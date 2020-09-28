<?php

/*
 * This file is part of a Job Portal Application Symfony Project.
 *
 * (c) Patrick Kenekayoro <Patrick.Kenekayoro@outlook.com>.
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookMediaRepository")
 * @ApiResource(
 *     iri="http://schema.org/BookMedia",
 *     normalizationContext={
 *         "groups"={"photo_read"},
 *     },
 * )
 * @Vich\Uploadable
 */
class PhotoMedia
{
    /**
     * @var string|null
     *
     * @ApiProperty(iri="http://schema.org/contentUrl")
     * @Groups({"photo_read"})
     */
    public $contentUrl;

    /**
     * @var File|null
     *
     * @Assert\NotNull(groups={"photo_object_create"})
     * @Assert\File(
     *     maxSize = "300K",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Please upload a valid Image less than 100KB"
     * )
     * @Vich\UploadableField(mapping="object_photo", fileNameProperty="filePath")
     */
    public $file;

    /**
     * @var string|null
     *
     * @ORM\Column(nullable=false, unique=true)
     * @Groups({"photo_read"})
     */
    public $filePath;
    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id
     */
    protected $id;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
