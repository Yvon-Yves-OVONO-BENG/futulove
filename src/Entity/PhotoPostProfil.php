<?php

namespace App\Entity;

use App\Repository\PhotoPostProfilRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoPostProfilRepository::class)]
class PhotoPostProfil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'photoPostProfils')]
    private ?PostProfil $postProfil = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?bool $supprime = null;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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
