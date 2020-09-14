<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"country-read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"country-read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"country-read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=State::class, mappedBy="country", orphanRemoval=true)
     * @Groups({"country-read"})
     */
    private $states;

    /**
     * @ORM\OneToMany(targetEntity=Position::class, mappedBy="country")
     */
    private $positions;

    public function __construct()
    {
        $this->states = new ArrayCollection();
        $this->positions = new ArrayCollection();
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

    /**
     * @return Collection|State[]
     */
    public function getStates(): Collection
    {
        return $this->states;
    }

    public function addState(State $state): self
    {
        if (!$this->states->contains($state)) {
            $this->states[] = $state;
            $state->setCountry($this);
        }

        return $this;
    }

    public function removeState(State $state): self
    {
        if ($this->states->contains($state)) {
            $this->states->removeElement($state);
            // set the owning side to null (unless already changed)
            if ($state->getCountry() === $this) {
                $state->setCountry(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection|Position[]
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPosition(Position $position): self
    {
        if (!$this->positions->contains($position)) {
            $this->positions[] = $position;
            $position->setCountry($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            // set the owning side to null (unless already changed)
            if ($position->getCountry() === $this) {
                $position->setCountry(null);
            }
        }

        return $this;
    }
}
