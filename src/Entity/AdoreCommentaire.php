<?php

namespace App\Entity;

use App\Repository\AdoreCommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdoreCommentaireRepository::class)]
class AdoreCommentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'adoreCommentaires')]
    private ?Commentaire $commentaire = null;

    #[ORM\ManyToOne(inversedBy: 'adoreCommentaires')]
    private ?User $adorePar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?Commentaire
    {
        return $this->commentaire;
    }

    public function setCommentaire(?Commentaire $commentaire): self
    {
        $this->commentaire = $commentaire;

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
