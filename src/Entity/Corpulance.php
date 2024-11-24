<?php

namespace App\Entity;

use App\Repository\CorpulanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CorpulanceRepository::class)]
class Corpulance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $corpulance = null;

    #[ORM\OneToMany(mappedBy: 'corpulance', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'corpulance', targetEntity: Preference::class)]
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

    public function getCorpulance(): ?string
    {
        return $this->corpulance;
    }

    public function setCorpulance(string $corpulance): self
    {
        $this->corpulance = $corpulance;

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
            $user->setCorpulance($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCorpulance() === $this) {
                $user->setCorpulance(null);
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
            $preference->setCorpulance($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): self
    {
        if ($this->preferences->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getCorpulance() === $this) {
                $preference->setCorpulance(null);
            }
        }

        return $this;
    }
}
