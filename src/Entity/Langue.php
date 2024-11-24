<?php

namespace App\Entity;

use App\Repository\LangueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LangueRepository::class)]
class Langue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $langue = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'langue', targetEntity: LangueMembre::class)]
    private Collection $langueMembres;

    public function __construct()
    {
        $this->langueMembres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function isSupprime(): ?bool
    {
        return $this->supprime;
    }

    public function setSupprime(bool $supprime): self
    {
        $this->supprime = $supprime;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, LangueMembre>
     */
    public function getLangueMembres(): Collection
    {
        return $this->langueMembres;
    }

    public function addLangueMembre(LangueMembre $langueMembre): self
    {
        if (!$this->langueMembres->contains($langueMembre)) {
            $this->langueMembres->add($langueMembre);
            $langueMembre->setLangue($this);
        }

        return $this;
    }

    public function removeLangueMembre(LangueMembre $langueMembre): self
    {
        if ($this->langueMembres->removeElement($langueMembre)) {
            // set the owning side to null (unless already changed)
            if ($langueMembre->getLangue() === $this) {
                $langueMembre->setLangue(null);
            }
        }

        return $this;
    }
}
