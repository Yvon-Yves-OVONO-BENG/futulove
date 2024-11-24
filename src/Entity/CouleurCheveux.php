<?php

namespace App\Entity;

use App\Repository\CouleurCheveuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouleurCheveuxRepository::class)]
class CouleurCheveux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $couleurCheveux = null;

    #[ORM\OneToMany(mappedBy: 'couleurCheveux', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'couleurCheveux', targetEntity: Preference::class)]
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

    public function getCouleurCheveux(): ?string
    {
        return $this->couleurCheveux;
    }

    public function setCouleurCheveux(string $couleurCheveux): self
    {
        $this->couleurCheveux = $couleurCheveux;

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
            $user->setCouleurCheveux($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCouleurCheveux() === $this) {
                $user->setCouleurCheveux(null);
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
            $preference->setCouleurCheveux($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): self
    {
        if ($this->preferences->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getCouleurCheveux() === $this) {
                $preference->setCouleurCheveux(null);
            }
        }

        return $this;
    }
}
