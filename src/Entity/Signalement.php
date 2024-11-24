<?php

namespace App\Entity;

use App\Repository\SignalementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SignalementRepository::class)]
class Signalement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'signalerPar')]
    private ?User $signalePar = null;

    #[ORM\ManyToOne(inversedBy: 'compteSignale')]
    private ?User $compteSignale = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateSignalementAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDesignalementAt = null;

    #[ORM\Column]
    private ?bool $etatSignalement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSignalePar(): ?User
    {
        return $this->signalePar;
    }

    public function setSignalePar(?User $signalePar): self
    {
        $this->signalePar = $signalePar;

        return $this;
    }

    public function getCompteSignale(): ?User
    {
        return $this->compteSignale;
    }

    public function setCompteSignale(?User $compteSignale): self
    {
        $this->compteSignale = $compteSignale;

        return $this;
    }

    public function getDateSignalementAt(): ?\DateTimeInterface
    {
        return $this->dateSignalementAt;
    }

    public function setDateSignalementAt(?\DateTimeInterface $dateSignalementAt): self
    {
        $this->dateSignalementAt = $dateSignalementAt;

        return $this;
    }

    public function getDateDesignalementAt(): ?\DateTimeInterface
    {
        return $this->dateDesignalementAt;
    }

    public function setDateDesignalementAt(?\DateTimeInterface $dateDesignalementAt): self
    {
        $this->dateDesignalementAt = $dateDesignalementAt;

        return $this;
    }

    public function isEtatSignalement(): ?bool
    {
        return $this->etatSignalement;
    }

    public function setEtatSignalement(bool $etatSignalement): self
    {
        $this->etatSignalement = $etatSignalement;

        return $this;
    }
}
