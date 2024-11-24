<?php

namespace App\Entity;

use App\Repository\AgeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgeRepository::class)]
class Age
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\OneToMany(mappedBy: 'ageMin', targetEntity: Preference::class)]
    private Collection $ageMin;

    #[ORM\OneToMany(mappedBy: 'ageMax', targetEntity: Preference::class)]
    private Collection $ageMax;

    public function __construct()
    {
        $this->ageMin = new ArrayCollection();
        $this->ageMax = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return Collection<int, Preference>
     */
    public function getAgeMin(): Collection
    {
        return $this->ageMin;
    }

    public function addAgeMin(Preference $ageMin): self
    {
        if (!$this->ageMin->contains($ageMin)) {
            $this->ageMin->add($ageMin);
            $ageMin->setAgeMin($this);
        }

        return $this;
    }

    public function removeAgeMin(Preference $ageMin): self
    {
        if ($this->ageMin->removeElement($ageMin)) {
            // set the owning side to null (unless already changed)
            if ($ageMin->getAgeMin() === $this) {
                $ageMin->setAgeMin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Preference>
     */
    public function getAgeMax(): Collection
    {
        return $this->ageMax;
    }

    public function addAgeMax(Preference $ageMax): self
    {
        if (!$this->ageMax->contains($ageMax)) {
            $this->ageMax->add($ageMax);
            $ageMax->setAgeMax($this);
        }

        return $this;
    }

    public function removeAgeMax(Preference $ageMax): self
    {
        if ($this->ageMax->removeElement($ageMax)) {
            // set the owning side to null (unless already changed)
            if ($ageMax->getAgeMax() === $this) {
                $ageMax->setAgeMax(null);
            }
        }

        return $this;
    }
}

