<?php

namespace App\Entity;

use App\Repository\CommentairePostProfilRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentairePostProfilRepository::class)]
class CommentairePostProfil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commentairePostProfils')]
    private ?PostProfil $postProfil = null;

    #[ORM\ManyToOne(inversedBy: 'commentairePostProfils')]
    private ?User $auteur = null;

    #[ORM\Column(length: 255)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $commenteLeAt = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostProfil(): ?PostProfil
    {
        return $this->postProfil;
    }

    public function setPostProfil(?PostProfil $postProfil): self
    {
        $this->postProfil = $postProfil;

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getCommenteLeAt(): ?\DateTimeInterface
    {
        return $this->commenteLeAt;
    }

    public function setCommenteLeAt(\DateTimeInterface $commenteLeAt): self
    {
        $this->commenteLeAt = $commenteLeAt;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
