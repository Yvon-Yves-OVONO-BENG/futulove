<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    private ?User $auteur = null;

    #[ORM\Column(length: 255)]
    private ?string $titreAlbum = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creeLeAt = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    private ?User $supprimePar = null;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: PhotoAlbum::class)]
    private Collection $photoAlbums;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    private ?TypeAlbum $typeAlbum = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->photoAlbums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitreAlbum(): ?string
    {
        return $this->titreAlbum;
    }

    public function setTitreAlbum(string $titreAlbum): self
    {
        $this->titreAlbum = $titreAlbum;

        return $this;
    }

    public function getCreeLeAt(): ?\DateTimeInterface
    {
        return $this->creeLeAt;
    }

    public function setCreeLeAt(\DateTimeInterface $creeLeAt): self
    {
        $this->creeLeAt = $creeLeAt;

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

    public function getSupprimeLeAt(): ?\DateTimeInterface
    {
        return $this->supprimeLeAt;
    }

    public function setSupprimeLeAt(?\DateTimeInterface $supprimeLeAt): self
    {
        $this->supprimeLeAt = $supprimeLeAt;

        return $this;
    }

    public function getSupprimePar(): ?User
    {
        return $this->supprimePar;
    }

    public function setSupprimePar(?User $supprimePar): self
    {
        $this->supprimePar = $supprimePar;

        return $this;
    }

    /**
     * @return Collection<int, PhotoAlbum>
     */
    public function getPhotoAlbums(): Collection
    {
        return $this->photoAlbums;
    }

    public function addPhotoAlbum(PhotoAlbum $photoAlbum): self
    {
        if (!$this->photoAlbums->contains($photoAlbum)) {
            $this->photoAlbums->add($photoAlbum);
            $photoAlbum->setAlbum($this);
        }

        return $this;
    }

    public function removePhotoAlbum(PhotoAlbum $photoAlbum): self
    {
        if ($this->photoAlbums->removeElement($photoAlbum)) {
            // set the owning side to null (unless already changed)
            if ($photoAlbum->getAlbum() === $this) {
                $photoAlbum->setAlbum(null);
            }
        }

        return $this;
    }

    public function getTypeAlbum(): ?TypeAlbum
    {
        return $this->typeAlbum;
    }

    public function setTypeAlbum(?TypeAlbum $typeAlbum): self
    {
        $this->typeAlbum = $typeAlbum;

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
