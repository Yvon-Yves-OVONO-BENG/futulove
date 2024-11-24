<?php

namespace App\Entity;

use App\Repository\CouleurYeuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouleurYeuxRepository::class)]
class CouleurYeux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $couleurYeux = null;

    #[ORM\OneToMany(mappedBy: 'couleurYeux', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'couleurYeux', targetEntity: Preference::class)]
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

    public function getCouleurYeux(): ?string
    {
        return $this->couleurYeux;
    }

    public function setCouleurYeux(string $couleurYeux): self
    {
        $this->couleurYeux = $couleurYeux;

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
            $user->setCouleurYeux($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCouleurYeux() === $this) {
                $user->setCouleurYeux(null);
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
            $preference->setCouleurYeux($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): self
    {
        if ($this->preferences->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getCouleurYeux() === $this) {
                $preference->setCouleurYeux(null);
            }
        }

        return $this;
    }
}
