<?php

namespace App\Entity;

use App\Repository\PostProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostProfilRepository::class)]
class PostProfil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'postProfils')]
    private ?User $auteur = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $publieLeAt = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\OneToMany(mappedBy: 'postProfil', targetEntity: PhotoPostProfil::class)]
    private Collection $photoPostProfils;

    #[ORM\OneToMany(mappedBy: 'postProfil', targetEntity: CommentairePostProfil::class)]
    private Collection $commentairePostProfils;

    public function __construct()
    {
        $this->photoPostProfils = new ArrayCollection();
        $this->commentairePostProfils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPublieLeAt(): ?\DateTimeInterface
    {
        return $this->publieLeAt;
    }

    public function setPublieLeAt(?\DateTimeInterface $publieLeAt): self
    {
        $this->publieLeAt = $publieLeAt;

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

    /**
     * @return Collection<int, PhotoPostProfil>
     */
    public function getPhotoPostProfils(): Collection
    {
        return $this->photoPostProfils;
    }

    public function addPhotoPostProfil(PhotoPostProfil $photoPostProfil): self
    {
        if (!$this->photoPostProfils->contains($photoPostProfil)) {
            $this->photoPostProfils->add($photoPostProfil);
            $photoPostProfil->setPostProfil($this);
        }

        return $this;
    }

    public function removePhotoPostProfil(PhotoPostProfil $photoPostProfil): self
    {
        if ($this->photoPostProfils->removeElement($photoPostProfil)) {
            // set the owning side to null (unless already changed)
            if ($photoPostProfil->getPostProfil() === $this) {
                $photoPostProfil->setPostProfil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommentairePostProfil>
     */
    public function getCommentairePostProfils(): Collection
    {
        return $this->commentairePostProfils;
    }

    public function addCommentairePostProfil(CommentairePostProfil $commentairePostProfil): self
    {
        if (!$this->commentairePostProfils->contains($commentairePostProfil)) {
            $this->commentairePostProfils->add($commentairePostProfil);
            $commentairePostProfil->setPostProfil($this);
        }

        return $this;
    }

    public function removeCommentairePostProfil(CommentairePostProfil $commentairePostProfil): self
    {
        if ($this->commentairePostProfils->removeElement($commentairePostProfil)) {
            // set the owning side to null (unless already changed)
            if ($commentairePostProfil->getPostProfil() === $this) {
                $commentairePostProfil->setPostProfil(null);
            }
        }

        return $this;
    }
}
