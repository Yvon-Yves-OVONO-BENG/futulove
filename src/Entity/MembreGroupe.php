<?php

namespace App\Entity;

use App\Repository\MembreGroupeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreGroupeRepository::class)]
class MembreGroupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'membreGroupes')]
    private ?Groupe $groupe = null;

    #[ORM\ManyToOne(inversedBy: 'membreGroupes')]
    private ?User $membre = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $ajouteLeAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $retireLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'membreGroupes')]
    private ?User $retirePar = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etatDemande = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDemandeAt = null;

    #[ORM\Column]
    private ?bool $bloque = null;

    #[ORM\Column(nullable: true)]
    private ?bool $invitation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $demande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
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

    public function isSupprime(): ?bool
    {
        return $this->supprime;
    }

    public function setSupprime(bool $supprime): self
    {
        $this->supprime = $supprime;

        return $this;
    }

    public function getAjouteLeAt(): ?\DateTimeInterface
    {
        return $this->ajouteLeAt;
    }

    public function setAjouteLeAt(\DateTimeInterface $ajouteLeAt): self
    {
        $this->ajouteLeAt = $ajouteLeAt;

        return $this;
    }

    public function getRetireLeAt(): ?\DateTimeInterface
    {
        return $this->retireLeAt;
    }

    public function setRetireLeAt(\DateTimeInterface $retireLeAt): self
    {
        $this->retireLeAt = $retireLeAt;

        return $this;
    }

    public function getRetirePar(): ?User
    {
        return $this->retirePar;
    }

    public function setRetirePar(?User $retirePar): self
    {
        $this->retirePar = $retirePar;

        return $this;
    }

    public function isEtatDemande(): ?bool
    {
        return $this->etatDemande;
    }

    public function setEtatDemande(?bool $etatDemande): self
    {
        $this->etatDemande = $etatDemande;

        return $this;
    }

    public function getDateDemandeAt(): ?\DateTimeInterface
    {
        return $this->dateDemandeAt;
    }

    public function setDateDemandeAt(?\DateTimeInterface $dateDemandeAt): self
    {
        $this->dateDemandeAt = $dateDemandeAt;

        return $this;
    }

    public function isBloque(): ?bool
    {
        return $this->bloque;
    }

    public function setBloque(bool $bloque): self
    {
        $this->bloque = $bloque;

        return $this;
    }

    public function isInvitation(): ?bool
    {
        return $this->invitation;
    }

    public function setInvitation(?bool $invitation): self
    {
        $this->invitation = $invitation;

        return $this;
    }

    public function isDemande(): ?bool
    {
        return $this->demande;
    }

    public function setDemande(?bool $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

}
