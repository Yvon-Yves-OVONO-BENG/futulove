<?php

namespace App\Entity;

use App\Repository\MessagePriveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagePriveRepository::class)]
class MessagePrive
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $messagePrive = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $messageRepondu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateMessage = null;

    #[ORM\ManyToOne(inversedBy: 'messagePrives')]
    private ?User $membre = null;

    #[ORM\Column(nullable: true)]
    private ?bool $lu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $luAAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessagePrive(): ?string
    {
        return $this->messagePrive;
    }

    public function setMessagePrive(?string $messagePrive): self
    {
        $this->messagePrive = $messagePrive;

        return $this;
    }

    public function getMessageRepondu(): ?self
    {
        return $this->messageRepondu;
    }

    public function setMessageRepondu(?self $messageRepondu): self
    {
        $this->messageRepondu = $messageRepondu;

        return $this;
    }

    public function getDateMessage(): ?\DateTimeInterface
    {
        return $this->dateMessage;
    }

    public function setDateMessage(?\DateTimeInterface $dateMessage): self
    {
        $this->dateMessage = $dateMessage;

        return $this;
    }

    public function getMembre(): ?User
    {
        return $this->membre;
    }

    public function setMembre(?User $membre): self
    {
        $this->membre = $membre;

        return $this;
    }

    public function isLu(): ?bool
    {
        return $this->lu;
    }

    public function setLu(?bool $lu): self
    {
        $this->lu = $lu;

        return $this;
    }

    public function getLuAAt(): ?\DateTimeInterface
    {
        return $this->luAAt;
    }

    public function setLuAAt(?\DateTimeInterface $luAAt): self
    {
        $this->luAAt = $luAAt;

        return $this;
    }
}
