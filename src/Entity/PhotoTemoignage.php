<?php

namespace App\Entity;

use App\Repository\PhotoTemoignageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoTemoignageRepository::class)]
class PhotoTemoignage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'photoTemoignages')]
    private ?Temoignage $temoignange = null;

    #[ORM\Column(length: 255)]
    private ?string $photoTemoignage = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemoignange(): ?Temoignage
    {
        return $this->temoignange;
    }

    public function setTemoignange(?Temoignage $temoignange): self
    {
        $this->temoignange = $temoignange;

        return $this;
    }

    public function getPhotoTemoignage(): ?string
    {
        return $this->photoTemoignage;
    }

    public function setPhotoTemoignage(string $photoTemoignage): self
    {
        $this->photoTemoignage = $photoTemoignage;

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
