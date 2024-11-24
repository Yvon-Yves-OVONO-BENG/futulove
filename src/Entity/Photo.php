<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPhoto = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPhoto(): ?string
    {
        return $this->nomPhoto;
    }

    public function setNomPhoto(string $nomPhoto): self
    {
        $this->nomPhoto = $nomPhoto;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
