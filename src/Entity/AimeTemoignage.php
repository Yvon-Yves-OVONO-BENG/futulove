<?php

namespace App\Entity;

use App\Repository\AimeTemoignageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AimeTemoignageRepository::class)]
class AimeTemoignage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'aimeTemoignages')]
    private ?Temoignage $temoignage = null;

    #[ORM\ManyToOne(inversedBy: 'aimeTemoignages')]
    private ?User $aimePar = null;

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

    public function getAimePar(): ?User
    {
        return $this->aimePar;
    }

    public function setAimePar(?User $aimePar): self
    {
        $this->aimePar = $aimePar;

        return $this;
    }
}
