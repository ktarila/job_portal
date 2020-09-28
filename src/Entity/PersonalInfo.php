<?php

/*
 * This file is part of a Job Portal Application Symfony Project.
 *
 * (c) Patrick Kenekayoro <Patrick.Kenekayoro@outlook.com>.
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\PersonalInfoActions\CreatePersonalInfo;
use App\Repository\PersonalInfoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PersonalInfoRepository::class)
 * @ApiResource(
 *     attributes={"order"={"id": "DESC"}},
 *     normalizationContext={"groups"={"info-read"}},
 *     denormalizationContext={"groups"={"write"}},
 *     collectionOperations = {
 *          "get"={
 *              "method"="GET",
 *              "path"="/personal-info.{_format}",
 *          },
 *          "post"={
 *         "method"="POST",
 *         "path"="/personal-info.{_format}",
 *         "controller"=CreatePersonalInfo::class,
 *     }
 *      },
 * )
 */
class PersonalInfo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"info-read", "write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"info-read", "write"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"info-read", "write"})
     */
    private $middlename;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"info-read", "write"})
     */
    private $lastname;

    /**
     * @ORM\OneToOne(targetEntity=PhotoMedia::class, cascade={"persist", "remove"})
     */
    private $avatar;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMiddlename(): ?string
    {
        return $this->middlename;
    }

    public function setMiddlename(?string $middlename): self
    {
        $this->middlename = $middlename;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAvatar(): ?PhotoMedia
    {
        return $this->avatar;
    }

    public function setAvatar(?PhotoMedia $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
