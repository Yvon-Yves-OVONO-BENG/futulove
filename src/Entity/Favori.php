<?php

namespace App\Entity;

use App\Repository\FavoriRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriRepository::class)]
class Favori
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'moi')]
    private ?User $moi = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    private ?User $favori = null;

    #[ORM\Column]
    private ?bool $etatFavori= null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAjoutFavoriAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateSuppressionFavoriAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoi(): ?User
    {
        return $this->moi;
    }

    public function setMoi(?User $moi): self
    {
        $this->moi = $moi;

        return $this;
    }

    public function getFavori(): ?User
    {
        return $this->favori;
    }

    public function setFavori(?User $favori): self
    {
        $this->favori = $favori;

        return $this;
    }

    public function isEtatFavori(): ?bool
    {
        return $this->etatFavori;
    }

    public function setEtatFavori(bool $etatFavori): self
    {
        $this->etatFavori= $etatFavori;

        return $this;
    }

    public function getDateAjoutFavoriAt(): ?\DateTimeInterface
    {
        return $this->dateAjoutFavoriAt;
    }

    public function setDateAjoutFavoriAt(?\DateTimeInterface $dateAjoutFavoriAt): self
    {
        $this->dateAjoutFavoriAt = $dateAjoutFavoriAt;

        return $this;
    }

    public function getDateSuppressionFavoriAt(): ?\DateTimeInterface
    {
        return $this->dateSuppressionFavoriAt;
    }

    public function setDateSuppressionFavoriAt(?\DateTimeInterface $dateSuppressionFavoriAt): self
    {
        $this->dateSuppressionFavoriAt = $dateSuppressionFavoriAt;

        return $this;
    }
}
