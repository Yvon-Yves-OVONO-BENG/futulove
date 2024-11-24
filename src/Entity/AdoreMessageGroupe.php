<?php

namespace App\Entity;

use App\Repository\AdoreMessageGroupeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdoreMessageGroupeRepository::class)]
class AdoreMessageGroupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'adoreMessageGroupes')]
    private ?MessageGroupe $messageGroupe = null;

    #[ORM\ManyToOne(inversedBy: 'adoreMessageGroupes')]
    private ?User $adorePar = null;

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
