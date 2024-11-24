<?php

namespace App\Entity;

use App\Repository\LangueMembreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LangueMembreRepository::class)]
class LangueMembre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'langueMembres')]
    private ?User $membre = null;

    #[ORM\ManyToOne(inversedBy: 'langueMembres')]
    private ?Langue $langue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembre(): ?User
    {
        return $this->membre;
    }

    public function setMembre(?User $membre): self
    {
        $this->membre = $membre;

        return $this;
    }

    public function getLangue(): ?Langue
    {
        return $this->langue;
    }

    public function setLangue(?Langue $langue): self
    {
        $this->langue = $langue;

        return $this;
    }
}
