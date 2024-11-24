<?php

namespace App\Entity;

use App\Repository\PreferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceRepository::class)]
class Preference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'preferences')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'preferences')]
    private ?Sexe $genre = null;

    #[ORM\ManyToOne(inversedBy: 'preferences')]
    private ?Pays $pays = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $departement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\ManyToOne(inversedBy: 'preferences')]
    private ?Corpulance $corpulance = null;

    #[ORM\ManyToOne(inversedBy: 'preferences')]
    private ?CouleurYeux $couleurYeux = null;

    #[ORM\ManyToOne(inversedBy: 'preferences')]
    private ?CouleurCheveux $couleurCheveux = null;

    #[ORM\Column(nullable: true)]
    private ?int $taille = null;

    #[ORM\Column(nullable: true)]
    private ?int $poids = null;

    #[ORM\ManyToOne(inversedBy: 'preferences')]
    private ?Teint $teint = null;

    #[ORM\ManyToOne(inversedBy: 'preferences')]
    private ?CigaretteVin $cigarette = null;

    #[ORM\ManyToOne(inversedBy: 'preferences')]
    private ?CigaretteVin $vin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $langue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $animauxDeCompagnie = null;

    #[ORM\ManyToOne(inversedBy: 'ageMin')]
    private ?Age $ageMin = null;

    #[ORM\ManyToOne(inversedBy: 'ageMax')]
    private ?Age $ageMax = null;

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

    public function getGenre(): ?Sexe
    {
        return $this->genre;
    }

    public function setGenre(?Sexe $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCorpulance(): ?Corpulance
    {
        return $this->corpulance;
    }

    public function setCorpulance(?Corpulance $corpulance): self
    {
        $this->corpulance = $corpulance;

        return $this;
    }

    public function getCouleurYeux(): ?CouleurYeux
    {
        return $this->couleurYeux;
    }

    public function setCouleurYeux(?CouleurYeux $couleurYeux): self
    {
        $this->couleurYeux = $couleurYeux;

        return $this;
    }

    public function getCouleurCheveux(): ?CouleurCheveux
    {
        return $this->couleurCheveux;
    }

    public function setCouleurCheveux(?CouleurCheveux $couleurCheveux): self
    {
        $this->couleurCheveux = $couleurCheveux;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getTeint(): ?Teint
    {
        return $this->teint;
    }

    public function setTeint(?Teint $teint): self
    {
        $this->teint = $teint;

        return $this;
    }

    public function getCigarette(): ?CigaretteVin
    {
        return $this->cigarette;
    }

    public function setCigarette(?CigaretteVin $cigarette): self
    {
        $this->cigarette = $cigarette;

        return $this;
    }

    public function getVin(): ?CigaretteVin
    {
        return $this->vin;
    }

    public function setVin(?CigaretteVin $vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getAnimauxDeCompagnie(): ?string
    {
        return $this->animauxDeCompagnie;
    }

    public function setAnimauxDeCompagnie(string $animauxDeCompagnie): self
    {
        $this->animauxDeCompagnie = $animauxDeCompagnie;

        return $this;
    }

    public function getAgeMin(): ?Age
    {
        return $this->ageMin;
    }

    public function setAgeMin(?Age $ageMin): self
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    public function getAgeMax(): ?Age
    {
        return $this->ageMax;
    }

    public function setAgeMax(?Age $ageMax): self
    {
        $this->ageMax = $ageMax;

        return $this;
    }
}
