<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Proxies\__CG__\App\Entity\Groupe as EntityGroupe;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
class Groupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomGroupe = null;

    #[ORM\ManyToOne(inversedBy: 'groupes')]
    private ?User $createur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creeLeAt = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\ManyToOne(inversedBy: 'groupes')]
    private ?User $supprimePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'groupes')]
    private ?TypeGroupe $typeGroupe = null;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: MembreGroupe::class)]
    private Collection $membreGroupes;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: MessageGroupe::class)]
    private Collection $messageGroupes;

    public function __construct()
    {
        $this->membreGroupes = new ArrayCollection();
        $this->messageGroupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGroupe(): ?string
    {
        return $this->nomGroupe;
    }

    public function setNomGroupe(string $nomGroupe): self
    {
        $this->nomGroupe = $nomGroupe;

        return $this;
    }

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getSupprimePar(): ?User
    {
        return $this->supprimePar;
    }

    public function setSupprimePar(?User $supprimePar): self
    {
        $this->supprimePar = $supprimePar;

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

    public function getTypeGroupe(): ?TypeGroupe
    {
        return $this->typeGroupe;
    }

    public function setTypeGroupe(?TypeGroupe $typeGroupe): self
    {
        $this->typeGroupe = $typeGroupe;

        return $this;
    }

    /**
     * @return Collection<int, MembreGroupe>
     */
    public function getMembreGroupes(): Collection
    {
        return $this->membreGroupes;
    }

    public function addMembreGroupe(MembreGroupe $membreGroupe): self
    {
        if (!$this->membreGroupes->contains($membreGroupe)) {
            $this->membreGroupes->add($membreGroupe);
            $membreGroupe->setGroupe($this);
        }

        return $this;
    }

    public function removeMembreGroupe(MembreGroupe $membreGroupe): self
    {
        if ($this->membreGroupes->removeElement($membreGroupe)) {
            // set the owning side to null (unless already changed)
            if ($membreGroupe->getGroupe() === $this) {
                $membreGroupe->setGroupe(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    // public function setPhoto(string $photo): self
    // {
    //     $this->photo = $photo;

    //     return $this;
    // }
    public function setPhoto(string $photo)
    {
        if ($photo instanceof File)
        {
            $this->photo = $photo;
        }
        elseif(is_string($photo))
        {
            $this->photo = $photo;
        }
        
    }

    public function estDejaInvite(User $user): bool
    {
        foreach ($this->membreGroupes as $membreGroupe) 
        {
            if($membreGroupe->getMembre() === $user && 
            $membreGroupe->isSupprime() == 0 && 
            $membreGroupe->isEtatDemande() == 0  )
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Collection<int, MessageGroupe>
     */
    public function getMessageGroupes(): Collection
    {
        return $this->messageGroupes;
    }

    public function addMessageGroupe(MessageGroupe $messageGroupe): self
    {
        if (!$this->messageGroupes->contains($messageGroupe)) {
            $this->messageGroupes->add($messageGroupe);
            $messageGroupe->setGroupe($this);
        }

        return $this;
    }

    public function removeMessageGroupe(MessageGroupe $messageGroupe): self
    {
        if ($this->messageGroupes->removeElement($messageGroupe)) {
            // set the owning side to null (unless already changed)
            if ($messageGroupe->getGroupe() === $this) {
                $messageGroupe->setGroupe(null);
            }
        }

        return $this;
    }
}
