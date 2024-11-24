<?php

namespace App\Entity;

use App\Repository\VerificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VerificationRepository::class)]
class Verification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'verifications')]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?int $code = null;

    #[ORM\Column(nullable: true)]
    private ?bool $estUtilise = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $valideAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(?int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function isEstUtilise(): ?bool
    {
        return $this->estUtilise;
    }

    public function setEstUtilise(?bool $estUtilise): self
    {
        $this->estUtilise = $estUtilise;

        return $this;
    }

    public function getValideAt(): ?\DateTimeInterface
    {
        return $this->valideAt;
    }

    public function setValideAt(?\DateTimeInterface $valideAt): self
    {
        $this->valideAt = $valideAt;

        return $this;
    }
}
