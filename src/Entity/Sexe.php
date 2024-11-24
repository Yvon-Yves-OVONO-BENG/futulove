<?php

namespace App\Entity;

use App\Repository\SexeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SexeRepository::class)]
class Sexe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $sexe = null;

    #[ORM\OneToMany(mappedBy: 'sexe', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'aLaRechercheDe', targetEntity: User::class)]
    private Collection $userRecherche;

    #[ORM\OneToMany(mappedBy: 'genre', targetEntity: Preference::class)]
    private Collection $preferences;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->userRecherche = new ArrayCollection();
        $this->preferences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setSexe($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getSexe() === $this) {
                $user->setSexe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserRecherche(): Collection
    {
        return $this->userRecherche;
    }

    public function addUserRecherche(User $userRecherche): self
    {
        if (!$this->userRecherche->contains($userRecherche)) {
            $this->userRecherche->add($userRecherche);
            $userRecherche->setALaRechercheDe($this);
        }

        return $this;
    }

    public function removeUserRecherche(User $userRecherche): self
    {
        if ($this->userRecherche->removeElement($userRecherche)) {
            // set the owning side to null (unless already changed)
            if ($userRecherche->getALaRechercheDe() === $this) {
                $userRecherche->setALaRechercheDe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Preference>
     */
    public function getPreferences(): Collection
    {
        return $this->preferences;
    }

    public function addPreference(Preference $preference): self
    {
        if (!$this->preferences->contains($preference)) {
            $this->preferences->add($preference);
            $preference->setGenre($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): self
    {
        if ($this->preferences->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getGenre() === $this) {
                $preference->setGenre(null);
            }
        }

        return $this;
    }
}
