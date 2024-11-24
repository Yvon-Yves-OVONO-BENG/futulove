<?php

namespace App\Entity;

use App\Repository\AimeCommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AimeCommentaireRepository::class)]
class AimeCommentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'aimeCommentaires')]
    private ?Commentaire $commentaire = null;

    #[ORM\ManyToOne(inversedBy: 'aimeCommentaires')]
    private ?User $aimePar = null;

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
