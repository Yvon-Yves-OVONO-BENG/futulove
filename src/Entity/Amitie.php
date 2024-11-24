<?php

namespace App\Entity;

use App\Repository\AmitieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AmitieRepository::class)]
class Amitie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'amitieDepart')]
    private ?User $demandePar = null;

    #[ORM\ManyToOne(inversedBy: 'amitieArrive')]
    private ?User $demandeA = null;

    #[ORM\Column]
    private ?int $statut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $demandeLeAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $amiDepuisAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $bloque = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemandePar(): ?User
    {
        return $this->demandePar;
    }

    public function setDemandePar(?User $demandePar): self
    {
        $this->demandePar = $demandePar;

        return $this;
    }

    public function getDemandeA(): ?User
    {
        return $this->demandeA;
    }

    public function setDemandeA(?User $demandeA): self
    {
        $this->demandeA = $demandeA;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDemandeLeAt(): ?\DateTimeInterface
    {
        return $this->demandeLeAt;
    }

    public function setDemandeLeAt(\DateTimeInterface $demandeLeAt): self
    {
        $this->demandeLeAt = $demandeLeAt;

        return $this;
    }

    public function getAmiDepuisAt(): ?\DateTimeInterface
    {
        return $this->amiDepuisAt;
    }

    public function setAmiDepuisAt(\DateTimeInterface $amiDepuisAt): self
    {
        $this->amiDepuisAt = $amiDepuisAt;

        return $this;
    }

    public function isBloque(): ?bool
    {
        return $this->bloque;
    }

    public function setBloque(?bool $bloque): self
    {
        $this->bloque = $bloque;

        return $this;
    }
}
