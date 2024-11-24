<?php

namespace App\Entity;

use App\Repository\AdoreTemoignageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdoreTemoignageRepository::class)]
class AdoreTemoignage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'adoreTemoignages')]
    private ?Temoignage $temoignage = null;

    #[ORM\ManyToOne(inversedBy: 'adoreTemoignages')]
    private ?User $adorePar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemoignage(): ?Temoignage
    {
        return $this->temoignage;
    }

    public function setTemoignage(?Temoignage $temoignage): self
    {
        $this->temoignage = $temoignage;

        return $this;
    }

    public function getAdorePar(): ?User
    {
        return $this->adorePar;
    }

    public function setAdorePar(?User $adorePar): self
    {
        $this->adorePar = $adorePar;

        return $this;
    }
}
