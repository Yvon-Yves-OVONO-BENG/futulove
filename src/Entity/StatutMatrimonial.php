<?php

namespace App\Entity;

use App\Repository\StatutMatrimonialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutMatrimonialRepository::class)]
class StatutMatrimonial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $statutMatrimonial = null;

    #[ORM\OneToMany(mappedBy: 'statutMatrimonial', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatutMatrimonial(): ?string
    {
        return $this->statutMatrimonial;
    }

    public function setStatutMatrimonial(string $statutMatrimonial): self
    {
        $this->statutMatrimonial = $statutMatrimonial;

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
            $user->setStatutMatrimonial($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getStatutMatrimonial() === $this) {
                $user->setStatutMatrimonial(null);
            }
        }

        return $this;
    }
}
