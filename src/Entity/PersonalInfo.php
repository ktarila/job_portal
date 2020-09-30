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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

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
 *              "method"="POST",
 *              "deserialize"=false,
 *              "path"="/personal-info.{_format}",
 *              "controller"=CreatePersonalInfo::class,
 *         }
 *   },
 * )
 * @UniqueEntity(
 *     fields={"userAccount"},
 *     errorPath="userAccount",
 *     message="Personal Information already created for user."
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
     * @Assert\NotBlank(message="Firstname must not be empty")
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
     * @Assert\NotBlank(message="Lastname must not be empty")
     */
    private $lastname;

    /**
     * @ORM\OneToOne(targetEntity=PhotoMedia::class, cascade={"persist", "remove"})
     */
    private $avatar;

    /**
     * @ORM\OneToOne(targetEntity=AppUser::class, inversedBy="personalInfo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $userAccount;

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

    public function getUserAccount(): ?AppUser
    {
        return $this->userAccount;
    }

    public function setUserAccount(AppUser $userAccount): self
    {
        $this->userAccount = $userAccount;

        return $this;
    }
}