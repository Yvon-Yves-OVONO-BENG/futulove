<?php

namespace App\Entity;

use App\Repository\FichierMessageGroupeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichierMessageGroupeRepository::class)]
class FichierMessageGroupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fichierMessageGroupes')]
    private ?MessageGroupe $messageGroupe = null;

    #[ORM\Column(length: 255)]
    private ?string $fichierMessageGroupe = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?bool $supprime = null;

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

    public function getFichierMessageGroupe(): ?string
    {
        return $this->fichierMessageGroupe;
    }

    public function setFichierMessageGroupe(string $fichierMessageGroupe): self
    {
        $this->fichierMessageGroupe = $fichierMessageGroupe;

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

    public function isSupprime(): ?bool
    {
        return $this->supprime;
    }

    public function setSupprime(bool $supprime): self
    {
        $this->supprime = $supprime;

        return $this;
    }
}
