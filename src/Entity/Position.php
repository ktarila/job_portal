<?php

/*
 * This file is part of a Job Portal Application Symfony Project.
 *
 * (c) Patrick Kenekayoro <Patrick.Kenekayoro@outlook.com>.
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\PositionActions\CreatePosition;
use App\Repository\PositionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PositionRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"position-read"}},
 *     denormalizationContext={"groups"={"write"}},
 *     collectionOperations = {
 *          "get"={
 *              "method"="GET",
 *              "path"="/positions{_format}",
 *          },
 *          "post"={
 *         "method"="POST",
 *         "path"="/positions.{_format}",
 *         "controller"=CreatePosition::class,
 *     }
 *      },
 * )
 */
class Position
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"position-read", "write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"position-read", "write"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Type(type="App\Entity\Country")
     * @Groups({"position-read", "write"})
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Type(type="App\Entity\State")
     * @Groups({"position-read", "write"})
     */
    private $state;

    /**
     * @ORM\Column(type="date")
     * @Groups({"position-read"})
     */
    private $date_posted;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Uuid
     * @Groups({"position-read"})
     */
    private $code;

    /**
     * @ORM\Column(type="date")
     * @Groups({"position-read", "write"})
     */
    private $deadline;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Groups({"position-read", "write"})
     */
    private $description;

    public function __construct()
    {
        $this->date_posted = new \DateTime();
        $this->code = Uuid::v4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getDatePosted(): ?\DateTimeInterface
    {
        return $this->date_posted;
    }

    public function setDatePosted(\DateTimeInterface $date_posted): self
    {
        $this->date_posted = $date_posted;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
