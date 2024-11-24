<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaysRepository::class)]
class Pays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\OneToMany(mappedBy: 'pays', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column(length: 255)]
    private ?string $drapeau = null;

    #[ORM\OneToMany(mappedBy: 'pays', targetEntity: Preference::class)]
    private Collection $preferences;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->preferences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

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
            $user->setPays($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPays() === $this) {
                $user->setPays(null);
            }
        }

        return $this;
    }

    public function getDrapeau(): ?string
    {
        return $this->drapeau;
    }

    public function setDrapeau(string $drapeau): self
    {
        $this->drapeau = $drapeau;

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
            $preference->setPays($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): self
    {
        if ($this->preferences->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getPays() === $this) {
                $preference->setPays(null);
            }
        }

        return $this;
    }
}
