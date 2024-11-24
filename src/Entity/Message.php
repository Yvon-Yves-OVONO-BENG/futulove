<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?Conversation $conversation = null;

    #[ORM\ManyToOne(inversedBy: 'messageOrigine')]
    private ?User $envoyePar = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $envoyeLeAt = null;

    #[ORM\Column]
    private ?bool $estLu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $luAt = null;

    #[ORM\ManyToOne(inversedBy: 'messageDestination')]
    private ?User $envoyeA = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fichier = null;

    #[ORM\Column(nullable: true)]
    private ?bool $estSupprime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConversation(): ?Conversation
    {
        return $this->conversation;
    }

    public function setConversation(?Conversation $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }

    public function getEnvoyePar(): ?User
    {
        return $this->envoyePar;
    }

    public function setEnvoyePar(?User $envoyePar): self
    {
        $this->envoyePar = $envoyePar;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getEnvoyeLeAt(): ?\DateTimeInterface
    {
        return $this->envoyeLeAt;
    }

    public function setEnvoyeLeAt(\DateTimeInterface $envoyeLeAt): self
    {
        $this->envoyeLeAt = $envoyeLeAt;

        return $this;
    }

    public function isEstLu(): ?bool
    {
        return $this->estLu;
    }

    public function setEstLu(bool $estLu): self
    {
        $this->estLu = $estLu;

        return $this;
    }

    public function getLuAt(): ?\DateTimeInterface
    {
        return $this->luAt;
    }

    public function setLuAt(\DateTimeInterface $luAt): self
    {
        $this->luAt = $luAt;

        return $this;
    }

    public function getEnvoyeA(): ?User
    {
        return $this->envoyeA;
    }

    public function setEnvoyeA(?User $envoyeA): self
    {
        $this->envoyeA = $envoyeA;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(?string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function isEstSupprime(): ?bool
    {
        return $this->estSupprime;
    }

    public function setEstSupprime(?bool $estSupprime): self
    {
        $this->estSupprime = $estSupprime;

        return $this;
    }
}
