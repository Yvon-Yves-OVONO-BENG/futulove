<?php

namespace App\Entity;

use App\Repository\TemoignageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemoignageRepository::class)]
class Temoignage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titreTemoignage = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $temoignage = null;

    #[ORM\ManyToOne(inversedBy: 'temoignages')]
    private ?User $createdBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'temoignange', targetEntity: PhotoTemoignage::class, cascade: ['persist', 'remove'])]
    private Collection $photoTemoignages;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\Column]
    private ?int $nombreVues = null;

    #[ORM\OneToMany(mappedBy: 'temoignage', targetEntity: Commentaire::class)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'temoignage', targetEntity: AimeTemoignage::class)]
    private Collection $aimeTemoignages;

    #[ORM\OneToMany(mappedBy: 'temoignage', targetEntity: AdoreTemoignage::class)]
    private Collection $adoreTemoignages;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeAt = null;

    #[ORM\ManyToOne(inversedBy: 'temoignagesSupprimes')]
    private ?User $supprimeBy = null;

    public function __construct()
    {
        $this->photoTemoignages = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->aimeTemoignages = new ArrayCollection();
        $this->adoreTemoignages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function estAimeParUser(User $user): bool
    {
        foreach ($this->aimeTemoignages as $aime) 
        {
            if($aime->getAimePar() === $user)
            {
                return true;
            }
        }

        return false;
    }

    public function estAdoreParUser(User $user): bool
    {
        foreach ($this->adoreTemoignages as $adore) 
        {
            if($adore->getAdorePar() === $user)
            {
                return true;
            }
        }

        return false;
    }

    public function getTitreTemoignage(): ?string
    {
        return $this->titreTemoignage;
    }

    public function setTitreTemoignage(string $titreTemoignage): self
    {
        $this->titreTemoignage = $titreTemoignage;

        return $this;
    }

    public function getTemoignage(): ?string
    {
        return $this->temoignage;
    }

    public function setTemoignage(string $temoignage): self
    {
        $this->temoignage = $temoignage;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    /**
     * @return Collection<int, PhotoTemoignage>
     */
    public function getPhotoTemoignages(): Collection
    {
        return $this->photoTemoignages;
    }

    public function addPhotoTemoignage(PhotoTemoignage $photoTemoignagne): self
    {
        if (!$this->photoTemoignages->contains($photoTemoignagne)) {
            $this->photoTemoignages->add($photoTemoignagne);
            $photoTemoignagne->setTemoignange($this);
        }

        return $this;
    }

    public function removePhotoTemoignage(PhotoTemoignage $photoTemoignagne): self
    {
        if ($this->photoTemoignages->removeElement($photoTemoignagne)) {
            // set the owning side to null (unless already changed)
            if ($photoTemoignagne->getTemoignange() === $this) {
                $photoTemoignagne->setTemoignange(null);
            }
        }

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

    public function getNombreVues(): ?int
    {
        return $this->nombreVues;
    }

    public function setNombreVues(int $nombreVues): self
    {
        $this->nombreVues = $nombreVues;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setTemoignage($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getTemoignage() === $this) {
                $commentaire->setTemoignage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AimeTemoignage>
     */
    public function getAimeTemoignages(): Collection
    {
        return $this->aimeTemoignages;
    }

    public function addAimeTemoignage(AimeTemoignage $aimeTemoignage): self
    {
        if (!$this->aimeTemoignages->contains($aimeTemoignage)) {
            $this->aimeTemoignages->add($aimeTemoignage);
            $aimeTemoignage->setTemoignage($this);
        }

        return $this;
    }

    public function removeAimeTemoignage(AimeTemoignage $aimeTemoignage): self
    {
        if ($this->aimeTemoignages->removeElement($aimeTemoignage)) {
            // set the owning side to null (unless already changed)
            if ($aimeTemoignage->getTemoignage() === $this) {
                $aimeTemoignage->setTemoignage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AdoreTemoignage>
     */
    public function getAdoreTemoignages(): Collection
    {
        return $this->adoreTemoignages;
    }

    public function addAdoreTemoignage(AdoreTemoignage $adoreTemoignage): self
    {
        if (!$this->adoreTemoignages->contains($adoreTemoignage)) {
            $this->adoreTemoignages->add($adoreTemoignage);
            $adoreTemoignage->setTemoignage($this);
        }

        return $this;
    }

    public function removeAdoreTemoignage(AdoreTemoignage $adoreTemoignage): self
    {
        if ($this->adoreTemoignages->removeElement($adoreTemoignage)) {
            // set the owning side to null (unless already changed)
            if ($adoreTemoignage->getTemoignage() === $this) {
                $adoreTemoignage->setTemoignage(null);
            }
        }

        return $this;
    }

    public function getSupprimeAt(): ?\DateTimeInterface
    {
        return $this->supprimeAt;
    }

    public function setSupprimeAt(?\DateTimeInterface $supprimeAt): self
    {
        $this->supprimeAt = $supprimeAt;

        return $this;
    }

    public function getSupprimeBy(): ?User
    {
        return $this->supprimeBy;
    }

    public function setSupprimeBy(?User $supprimeBy): self
    {
        $this->supprimeBy = $supprimeBy;

        return $this;
    }

}
