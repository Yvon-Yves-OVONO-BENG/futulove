<?php

namespace App\Entity;

use App\Repository\CigaretteVinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CigaretteVinRepository::class)]
class CigaretteVin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $cigaretteVin = null;

    #[ORM\OneToMany(mappedBy: 'fume', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'cigarette', targetEntity: Preference::class)]
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

    public function getCigaretteVin(): ?string
    {
        return $this->cigaretteVin;
    }

    public function setCigaretteVin(string $cigaretteVin): self
    {
        $this->cigaretteVin = $cigaretteVin;

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
            $user->setFume($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getFume() === $this) {
                $user->setFume(null);
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
            $preference->setCigarette($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): self
    {
        if ($this->preferences->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getCigarette() === $this) {
                $preference->setCigarette(null);
            }
        }

        return $this;
    }
}
