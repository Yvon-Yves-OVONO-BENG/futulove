<?php

namespace App\Entity;

use App\Repository\TypeAlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeAlbumRepository::class)]
class TypeAlbum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeAlbum = null;

    #[ORM\OneToMany(mappedBy: 'typeAlbum', targetEntity: Album::class)]
    private Collection $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAlbum(): ?string
    {
        return $this->typeAlbum;
    }

    public function setTypeAlbum(string $typeAlbum): self
    {
        $this->typeAlbum = $typeAlbum;

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->setTypeAlbum($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getTypeAlbum() === $this) {
                $album->setTypeAlbum(null);
            }
        }

        return $this;
    }
}
