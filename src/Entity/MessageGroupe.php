<?php

namespace App\Entity;

use App\Repository\MessageGroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageGroupeRepository::class)]
class MessageGroupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'messageGroupes')]
    private ?Groupe $groupe = null;

    #[ORM\ManyToOne(inversedBy: 'messageGroupes')]
    private ?User $auteur = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'messageGroupes')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $messageGroupes;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $messageGroupe = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creeLeAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeLeAt = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'messageGroupe', targetEntity: FichierMessageGroupe::class)]
    private Collection $fichierMessageGroupes;

    #[ORM\ManyToOne(inversedBy: 'supprimePar')]
    private ?User $supprimePar = null;

    #[ORM\OneToMany(mappedBy: 'messageGroupe', targetEntity: AimeMessageGroupe::class)]
    private Collection $aimeMessageGroupes;

    #[ORM\OneToMany(mappedBy: 'messageGroupe', targetEntity: AdoreMessageGroupe::class)]
    private Collection $adoreMessageGroupes;

    public function __construct()
    {
        $this->messageGroupes = new ArrayCollection();
        $this->fichierMessageGroupes = new ArrayCollection();
        $this->aimeMessageGroupes = new ArrayCollection();
        $this->adoreMessageGroupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

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
    public function getMessageGroupes(): Collection
    {
        return $this->messageGroupes;
    }

    public function addMessageGroupe(self $messageGroupe): self
    {
        if (!$this->messageGroupes->contains($messageGroupe)) {
            $this->messageGroupes->add($messageGroupe);
            $messageGroupe->setParent($this);
        }

        return $this;
    }

    public function removeMessageGroupe(self $messageGroupe): self
    {
        if ($this->messageGroupes->removeElement($messageGroupe)) {
            // set the owning side to null (unless already changed)
            if ($messageGroupe->getParent() === $this) {
                $messageGroupe->setParent(null);
            }
        }

        return $this;
    }

    public function getMessageGroupe(): ?string
    {
        return $this->messageGroupe;
    }

    public function setMessageGroupe(string $messageGroupe): self
    {
        $this->messageGroupe = $messageGroupe;

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

    public function getSupprimeLeAt(): ?\DateTimeInterface
    {
        return $this->supprimeLeAt;
    }

    public function setSupprimeLeAt(\DateTimeInterface $supprimeLeAt): self
    {
        $this->supprimeLeAt = $supprimeLeAt;

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

    /**
     * @return Collection<int, FichierMessageGroupe>
     */
    public function getFichierMessageGroupes(): Collection
    {
        return $this->fichierMessageGroupes;
    }

    public function addFichierMessageGroupe(FichierMessageGroupe $fichierMessageGroupe): self
    {
        if (!$this->fichierMessageGroupes->contains($fichierMessageGroupe)) {
            $this->fichierMessageGroupes->add($fichierMessageGroupe);
            $fichierMessageGroupe->setMessageGroupe($this);
        }

        return $this;
    }

    public function removeFichierMessageGroupe(FichierMessageGroupe $fichierMessageGroupe): self
    {
        if ($this->fichierMessageGroupes->removeElement($fichierMessageGroupe)) {
            // set the owning side to null (unless already changed)
            if ($fichierMessageGroupe->getMessageGroupe() === $this) {
                $fichierMessageGroupe->setMessageGroupe(null);
            }
        }

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
     * @return Collection<int, AimeMessageGroupe>
     */
    public function getAimeMessageGroupes(): Collection
    {
        return $this->aimeMessageGroupes;
    }

    public function addAimeMessageGroupe(AimeMessageGroupe $aimeMessageGroupe): self
    {
        if (!$this->aimeMessageGroupes->contains($aimeMessageGroupe)) {
            $this->aimeMessageGroupes->add($aimeMessageGroupe);
            $aimeMessageGroupe->setMessageGroupe($this);
        }

        return $this;
    }

    public function removeAimeMessageGroupe(AimeMessageGroupe $aimeMessageGroupe): self
    {
        if ($this->aimeMessageGroupes->removeElement($aimeMessageGroupe)) {
            // set the owning side to null (unless already changed)
            if ($aimeMessageGroupe->getMessageGroupe() === $this) {
                $aimeMessageGroupe->setMessageGroupe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AdoreMessageGroupe>
     */
    public function getAdoreMessageGroupes(): Collection
    {
        return $this->adoreMessageGroupes;
    }

    public function addAdoreMessageGroupe(AdoreMessageGroupe $adoreMessageGroupe): self
    {
        if (!$this->adoreMessageGroupes->contains($adoreMessageGroupe)) {
            $this->adoreMessageGroupes->add($adoreMessageGroupe);
            $adoreMessageGroupe->setMessageGroupe($this);
        }

        return $this;
    }

    public function removeAdoreMessageGroupe(AdoreMessageGroupe $adoreMessageGroupe): self
    {
        if ($this->adoreMessageGroupes->removeElement($adoreMessageGroupe)) {
            // set the owning side to null (unless already changed)
            if ($adoreMessageGroupe->getMessageGroupe() === $this) {
                $adoreMessageGroupe->setMessageGroupe(null);
            }
        }

        return $this;
    }

    public function estAimeParUser(User $user): bool
    {
        foreach ($this->aimeMessageGroupes as $aime) 
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
        foreach ($this->adoreMessageGroupes as $adore) 
        {
            if($adore->getAdorePar() === $user)
            {
                return true;
            }
        }

        return false;
    }
}
