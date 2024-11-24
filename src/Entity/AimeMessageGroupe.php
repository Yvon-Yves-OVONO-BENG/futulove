<?php

namespace App\Entity;

use App\Repository\AimeMessageGroupeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AimeMessageGroupeRepository::class)]
class AimeMessageGroupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'aimeMessageGroupes')]
    private ?MessageGroupe $messageGroupe = null;

    #[ORM\ManyToOne(inversedBy: 'aimeMessageGroupes')]
    private ?User $aimePar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessageGroupe(): ?MessageGroupe
    {
        return $this->messageGroupe;
    }

    public function setMessageGroupe(?MessageGroupe $messageGroupe): self
    {
        $this->messageGroupe = $messageGroupe;

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
