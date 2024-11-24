<?php

namespace App\Entity;

use App\Repository\PhotoAlbumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoAlbumRepository::class)]
class PhotoAlbum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $photoAlbum = null;

    #[ORM\ManyToOne(inversedBy: 'photoAlbums')]
    private ?Album $album = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhotoAlbum(): ?string
    {
        return $this->photoAlbum;
    }

    public function setPhotoAlbum(string $photoAlbum): self
    {
        $this->photoAlbum = $photoAlbum;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

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
