<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $commenteLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?User $auteur = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'commentaires')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $reponse;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeLeAt = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?Temoignage $temoignage = null;

    #[ORM\OneToMany(mappedBy: 'commentaire', targetEntity: AimeCommentaire::class)]
    private Collection $aimeCommentaires;

    #[ORM\OneToMany(mappedBy: 'commentaire', targetEntity: AdoreCommentaire::class)]
    private Collection $adoreCommentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->reponse = new ArrayCollection();
        $this->aimeCommentaires = new ArrayCollection();
        $this->adoreCommentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function estAimeParUser(User $user): bool
    {
        foreach ($this->aimeCommentaires as $aime) 
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
        foreach ($this->adoreCommentaires as $adore) 
        {
            if($adore->getAdorePar() === $user)
            {
                return true;
            }
        }

        return false;
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

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(self $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setParent($this);
        }

        return $this;
    }

    public function removeCommentaire(self $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getParent() === $this) {
                $commentaire->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getReponse(): Collection
    {
        return $this->reponse;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTemoignage(): ?Temoignage
    {
        return $this->temoignage;
    }

    public function setTemoignage(?Temoignage $temoignage): self
    {
        $this->temoignage = $temoignage;

        return $this;
    }

    /**
     * @return Collection<int, AimeCommentaire>
     */
    public function getAimeCommentaires(): Collection
    {
        return $this->aimeCommentaires;
    }

    public function addAimeCommentaire(AimeCommentaire $aimeCommentaire): self
    {
        if (!$this->aimeCommentaires->contains($aimeCommentaire)) {
            $this->aimeCommentaires->add($aimeCommentaire);
            $aimeCommentaire->setCommentaire($this);
        }

        return $this;
    }

    public function removeAimeCommentaire(AimeCommentaire $aimeCommentaire): self
    {
        if ($this->aimeCommentaires->removeElement($aimeCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($aimeCommentaire->getCommentaire() === $this) {
                $aimeCommentaire->setCommentaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AdoreCommentaire>
     */
    public function getAdoreCommentaires(): Collection
    {
        return $this->adoreCommentaires;
    }

    public function addAdoreCommentaire(AdoreCommentaire $adoreCommentaire): self
    {
        if (!$this->adoreCommentaires->contains($adoreCommentaire)) {
            $this->adoreCommentaires->add($adoreCommentaire);
            $adoreCommentaire->setCommentaire($this);
        }

        return $this;
    }

    public function removeAdoreCommentaire(AdoreCommentaire $adoreCommentaire): self
    {
        if ($this->adoreCommentaires->removeElement($adoreCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($adoreCommentaire->getCommentaire() === $this) {
                $adoreCommentaire->setCommentaire(null);
            }
        }

        return $this;
    }
}
