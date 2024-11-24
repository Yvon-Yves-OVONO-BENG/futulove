<?php

namespace App\Entity;

// use Serializable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
// use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
// use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

// #[Vich\Uploadable]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Un compte existe déjà avec cette email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
// , Serializable
{
    const PHOTO_ADDED_SUCCESSFULLY = 'PHOTO_ADDED_SUCCESSFULLY';
    const PHOTO_INVALID_FORM = 'PHOTO_INVALID_FORM';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe doivent être identiques")
     */
    private $confirmPassword;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?bool $isVerified = false;

    // #[Vich\UploadableField(mapping:"photo_Profil", fileNameProperty:"photoProfile")]
    // /**
    // *
    // * @var File|null
    //  */
    // private $photoProfileFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoProfile = null;

    #[ORM\Column(nullable: true)]
    private ?bool $enLigne = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $enLigneDepuisAt = null;

    #[ORM\Column(nullable: true)]
    private ?float $taille = null;

    #[ORM\Column(nullable: true)]
    private ?float $poids = null;

    #[ORM\Column(nullable: true)]
    private ?bool $temoinProfil = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Sexe $sexe = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Teint $teint = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?CouleurYeux $couleurYeux = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?CouleurCheveux $couleurCheveux = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Pays $pays = null;

    #[ORM\OneToMany(mappedBy: 'creePar', targetEntity: Conversation::class)]
    private Collection $conversations;

    #[ORM\OneToMany(mappedBy: 'envoyePar', targetEntity: Message::class)]
    private Collection $messageOrigine;

    #[ORM\OneToMany(mappedBy: 'envoyeA', targetEntity: Message::class)]
    private Collection $messageDestination;

    #[ORM\OneToMany(mappedBy: 'demandePar', targetEntity: Amitie::class)]
    private Collection $amitieDepart;

    #[ORM\OneToMany(mappedBy: 'demandeA', targetEntity: Amitie::class)]
    private Collection $amitieArrive;

    #[ORM\ManyToOne(inversedBy: 'userRecherche')]
    private ?Sexe $aLaRechercheDe = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'moi', targetEntity: Favori::class)]
    private Collection $moi;

    #[ORM\OneToMany(mappedBy: 'favori', targetEntity: Favori::class)]
    private Collection $favoris;

    #[ORM\OneToMany(mappedBy: 'avec', targetEntity: Conversation::class)]
    private Collection $Conversationavec;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pour = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Formule $formule = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Photo::class)]
    private Collection $photos;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoCouverture = null;

    #[ORM\OneToMany(mappedBy: 'signalePar', targetEntity: Signalement::class)]
    private Collection $signalerPar;

    #[ORM\OneToMany(mappedBy: 'compteSignale', targetEntity: Signalement::class)]
    private Collection $compteSignale;

    #[ORM\Column(nullable: true)]
    private ?bool $suspendu = null;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: MessagePrive::class)]
    private Collection $messagePrives;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $activationToken = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Verification::class)]
    private Collection $verifications;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Temoignage::class)]
    private Collection $temoignages;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNaissanceAt = null;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Commentaire::class)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'aimePar', targetEntity: AimeTemoignage::class)]
    private Collection $aimeTemoignages;

    #[ORM\OneToMany(mappedBy: 'adorePar', targetEntity: AdoreTemoignage::class)]
    private Collection $adoreTemoignages;

    #[ORM\OneToMany(mappedBy: 'aimePar', targetEntity: AimeCommentaire::class)]
    private Collection $aimeCommentaires;

    #[ORM\OneToMany(mappedBy: 'adorePar', targetEntity: AdoreCommentaire::class)]
    private Collection $adoreCommentaires;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: PostProfil::class)]
    private Collection $postProfils;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: CommentairePostProfil::class)]
    private Collection $commentairePostProfils;

    #[ORM\OneToMany(mappedBy: 'supprimeBy', targetEntity: Temoignage::class)]
    private Collection $temoignagesSupprimes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sloganDevise = null;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Album::class)]
    private Collection $albums;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $animauxDeCompagnie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieuVacancePrefere = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?StatutMatrimonial $statutMatrimonial = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?CigaretteVin $fume = null;

    #[ORM\ManyToOne]
    private ?CigaretteVin $boisson = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Corpulance $corpulance = null;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: LangueMembre::class)]
    private Collection $langueMembres;

    #[ORM\OneToMany(mappedBy: 'createur', targetEntity: Groupe::class)]
    private Collection $groupes;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: MembreGroupe::class)]
    private Collection $membreGroupes;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Preference::class)]
    private Collection $preferences;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $departement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: MessageGroupe::class)]
    private Collection $messageGroupes;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: MessageGroupe::class)]
    private Collection $supprimePar;

    #[ORM\OneToMany(mappedBy: 'aimePar', targetEntity: AimeMessageGroupe::class)]
    private Collection $aimeMessageGroupes;

    #[ORM\OneToMany(mappedBy: 'adorePar', targetEntity: AdoreMessageGroupe::class)]
    private Collection $adoreMessageGroupes;

    public function __construct()
    {
        $this->conversations = new ArrayCollection();
        $this->messageOrigine = new ArrayCollection();
        $this->messageDestination = new ArrayCollection();
        $this->amitieDepart = new ArrayCollection();
        $this->amitieArrive = new ArrayCollection();
        $this->moi = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->Conversationavec = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->signalerPar = new ArrayCollection();
        $this->compteSignale = new ArrayCollection();
        $this->messagePrives = new ArrayCollection();
        $this->verifications = new ArrayCollection();
        $this->temoignages = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->aimeTemoignages = new ArrayCollection();
        $this->adoreTemoignages = new ArrayCollection();
        $this->aimeCommentaires = new ArrayCollection();
        $this->adoreCommentaires = new ArrayCollection();
        $this->postProfils = new ArrayCollection();
        $this->commentairePostProfils = new ArrayCollection();
        $this->temoignagesSupprimes = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->langueMembres = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->membreGroupes = new ArrayCollection();
        $this->preferences = new ArrayCollection();
        $this->messageGroupes = new ArrayCollection();
        $this->supprimePar = new ArrayCollection();
        $this->aimeMessageGroupes = new ArrayCollection();
        $this->adoreMessageGroupes = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getConfirmPassword(): string
    {
        return (string) $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * Set the photoProfile file
     *
     * @param File|null $photoProfileFile
     * @return void
     */
    // public function setPhotoProfileFile(?File $photoProfileFile = null): void
    // {
    //     $this->photoProfileFile = $photoProfileFile;

    //     if($photoProfileFile !== null)
    //     {
    //         $this->setUpdatedAt(new \DateTime());
    //     }
    // }

    // public function getPhotoProfileFile(): ?File
    // {
    //     return $this->photoProfileFile;
    // }

    public function getPhotoProfile(): ?string
    {
        return $this->photoProfile;
    }

    public function setPhotoProfile(?string $photoProfile): self
    {
        $this->photoProfile = $photoProfile;

        return $this;
    }

    public function isEnLigne(): ?bool
    {
        return $this->enLigne;
    }

    public function setEnLigne(?bool $enLigne): self
    {
        $this->enLigne = $enLigne;

        return $this;
    }

    public function getEnLigneDepuisAt(): ?\DateTimeInterface
    {
        return $this->enLigneDepuisAt;
    }

    public function setEnLigneDepuisAt(?\DateTimeInterface $enLigneDepuisAt): self
    {
        $this->enLigneDepuisAt = $enLigneDepuisAt;

        return $this;
    }

    public function getTaille(): ?float
    {
        return $this->taille;
    }

    public function setTaille(?float $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(?float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function isTemoinProfil(): ?bool
    {
        return $this->temoinProfil;
    }

    public function setTemoinProfil(?bool $temoinProfil): self
    {
        $this->temoinProfil = $temoinProfil;

        return $this;
    }

    public function getSexe(): ?Sexe
    {
        return $this->sexe;
    }

    public function setSexe(?Sexe $sexe): self
    {
        $this->sexe = $sexe;

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

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): self
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations->add($conversation);
            $conversation->setCreePar($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): self
    {
        if ($this->conversations->removeElement($conversation)) {
            // set the owning side to null (unless already changed)
            if ($conversation->getCreePar() === $this) {
                $conversation->setCreePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessageOrigine(): Collection
    {
        return $this->messageOrigine;
    }

    public function addMessageOrigine(Message $messageOrigine): self
    {
        if (!$this->messageOrigine->contains($messageOrigine)) {
            $this->messageOrigine->add($messageOrigine);
            $messageOrigine->setEnvoyePar($this);
        }

        return $this;
    }

    public function removeMessageOrigine(Message $messageOrigine): self
    {
        if ($this->messageOrigine->removeElement($messageOrigine)) {
            // set the owning side to null (unless already changed)
            if ($messageOrigine->getEnvoyePar() === $this) {
                $messageOrigine->setEnvoyePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessageDestination(): Collection
    {
        return $this->messageDestination;
    }

    public function addMessageDestination(Message $messageDestination): self
    {
        if (!$this->messageDestination->contains($messageDestination)) {
            $this->messageDestination->add($messageDestination);
            $messageDestination->setEnvoyeA($this);
        }

        return $this;
    }

    public function removeMessageDestination(Message $messageDestination): self
    {
        if ($this->messageDestination->removeElement($messageDestination)) {
            // set the owning side to null (unless already changed)
            if ($messageDestination->getEnvoyeA() === $this) {
                $messageDestination->setEnvoyeA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Amitie>
     */
    public function getAmitieDepart(): Collection
    {
        return $this->amitieDepart;
    }

    public function addAmitieDepart(Amitie $amitieDepart): self
    {
        if (!$this->amitieDepart->contains($amitieDepart)) {
            $this->amitieDepart->add($amitieDepart);
            $amitieDepart->setDemandePar($this);
        }

        return $this;
    }

    public function removeAmitieDepart(Amitie $amitieDepart): self
    {
        if ($this->amitieDepart->removeElement($amitieDepart)) {
            // set the owning side to null (unless already changed)
            if ($amitieDepart->getDemandePar() === $this) {
                $amitieDepart->setDemandePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Amitie>
     */
    public function getAmitieArrive(): Collection
    {
        return $this->amitieArrive;
    }

    public function addAmitieArrive(Amitie $amitieArrive): self
    {
        if (!$this->amitieArrive->contains($amitieArrive)) {
            $this->amitieArrive->add($amitieArrive);
            $amitieArrive->setDemandeA($this);
        }

        return $this;
    }

    public function removeAmitieArrive(Amitie $amitieArrive): self
    {
        if ($this->amitieArrive->removeElement($amitieArrive)) {
            // set the owning side to null (unless already changed)
            if ($amitieArrive->getDemandeA() === $this) {
                $amitieArrive->setDemandeA(null);
            }
        }

        return $this;
    }

    public function getALaRechercheDe(): ?Sexe
    {
        return $this->aLaRechercheDe;
    }

    public function setALaRechercheDe(?Sexe $aLaRechercheDe): self
    {
        $this->aLaRechercheDe = $aLaRechercheDe;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function serialize()
    {
        $this->photoProfile = base64_encode($this->photoProfile);
    }

    public function unserialize($serialized)
    {
        $this->photoProfile = base64_decode($this->photoProfile);

    }

    /**
     * @return Collection<int, Favori>
     */
    public function getMoi(): Collection
    {
        return $this->moi;
    }

    public function addMoi(Favori $moi): self
    {
        if (!$this->moi->contains($moi)) {
            $this->moi->add($moi);
            $moi->setMoi($this);
        }

        return $this;
    }

    public function removeMoi(Favori $moi): self
    {
        if ($this->moi->removeElement($moi)) {
            // set the owning side to null (unless already changed)
            if ($moi->getMoi() === $this) {
                $moi->setMoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favori>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favori $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
            $favori->setFavori($this);
        }

        return $this;
    }

    public function removeFavori(Favori $favori): self
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getFavori() === $this) {
                $favori->setFavori(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversationavec(): Collection
    {
        return $this->Conversationavec;
    }

    public function addConversationavec(Conversation $conversationavec): self
    {
        if (!$this->Conversationavec->contains($conversationavec)) {
            $this->Conversationavec->add($conversationavec);
            $conversationavec->setAvec($this);
        }

        return $this;
    }

    public function removeConversationavec(Conversation $conversationavec): self
    {
        if ($this->Conversationavec->removeElement($conversationavec)) {
            // set the owning side to null (unless already changed)
            if ($conversationavec->getAvec() === $this) {
                $conversationavec->setAvec(null);
            }
        }

        return $this;
    }


    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getPour(): ?string
    {
        return $this->pour;
    }

    public function setPour(?string $pour): self
    {
        $this->pour = $pour;

        return $this;
    }

    public function getFormule(): ?Formule
    {
        return $this->formule;
    }

    public function setFormule(?Formule $formule): self
    {
        $this->formule = $formule;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setUser($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getUser() === $this) {
                $photo->setUser(null);
            }
        }

        return $this;
    }

    public function getPhotoCouverture(): ?string
    {
        return $this->photoCouverture;
    }

    public function setPhotoCouverture(?string $photoCouverture): self
    {
        $this->photoCouverture = $photoCouverture;

        return $this;
    }

    /**
     * @return Collection<int, Signalement>
     */
    public function getSignalerPar(): Collection
    {
        return $this->signalerPar;
    }

    public function addSignalerPar(Signalement $signalerPar): self
    {
        if (!$this->signalerPar->contains($signalerPar)) {
            $this->signalerPar->add($signalerPar);
            $signalerPar->setSignalePar($this);
        }

        return $this;
    }

    public function removeSignalerPar(Signalement $signalerPar): self
    {
        if ($this->signalerPar->removeElement($signalerPar)) {
            // set the owning side to null (unless already changed)
            if ($signalerPar->getSignalePar() === $this) {
                $signalerPar->setSignalePar(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Signalement>
     */
    public function getCompteSignale(): Collection
    {
        return $this->compteSignale;
    }

    public function addCompteSignale(Signalement $compteSignale): self
    {
        if (!$this->compteSignale->contains($compteSignale)) {
            $this->compteSignale->add($compteSignale);
            $compteSignale->setSignalePar($this);
        }

        return $this;
    }

    public function removeCompteSignale(Signalement $compteSignale): self
    {
        if ($this->compteSignale->removeElement($compteSignale)) {
            // set the owning side to null (unless already changed)
            if ($compteSignale->getCompteSignale() === $this) {
                $compteSignale->setCompteSignale(null);
            }
        }

        return $this;
    }

    public function isSuspendu(): ?bool
    {
        return $this->suspendu;
    }

    public function setSuspendu(?bool $suspendu): self
    {
        $this->suspendu = $suspendu;

        return $this;
    }

    /**
     * @return Collection<int, MessagePrive>
     */
    public function getMessagePrives(): Collection
    {
        return $this->messagePrives;
    }

    public function addMessagePrife(MessagePrive $messagePrife): self
    {
        if (!$this->messagePrives->contains($messagePrife)) {
            $this->messagePrives->add($messagePrife);
            $messagePrife->setMembre($this);
        }

        return $this;
    }

    public function removeMessagePrife(MessagePrive $messagePrife): self
    {
        if ($this->messagePrives->removeElement($messagePrife)) {
            // set the owning side to null (unless already changed)
            if ($messagePrife->getMembre() === $this) {
                $messagePrife->setMembre(null);
            }
        }

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }

    public function setActivationToken(string $activationToken): self
    {
        $this->activationToken = $activationToken;

        return $this;
    }

    /**
     * @return Collection<int, Verification>
     */
    public function getVerifications(): Collection
    {
        return $this->verifications;
    }

    public function addVerification(Verification $verification): self
    {
        if (!$this->verifications->contains($verification)) {
            $this->verifications->add($verification);
            $verification->setUser($this);
        }

        return $this;
    }

    public function removeVerification(Verification $verification): self
    {
        if ($this->verifications->removeElement($verification)) {
            // set the owning side to null (unless already changed)
            if ($verification->getUser() === $this) {
                $verification->setUser(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Temoignage>
     */
    public function getTemoignages(): Collection
    {
        return $this->temoignages;
    }

    public function addTemoignage(Temoignage $temoignage): self
    {
        if (!$this->temoignages->contains($temoignage)) {
            $this->temoignages->add($temoignage);
            $temoignage->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTemoignage(Temoignage $temoignage): self
    {
        if ($this->temoignages->removeElement($temoignage)) {
            // set the owning side to null (unless already changed)
            if ($temoignage->getCreatedBy() === $this) {
                $temoignage->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getDateNaissanceAt(): ?\DateTimeInterface
    {
        return $this->dateNaissanceAt;
    }

    public function setDateNaissanceAt(?\DateTimeInterface $dateNaissanceAt): self
    {
        $this->dateNaissanceAt = $dateNaissanceAt;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setAuteur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getAuteur() === $this) {
                $commentaire->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AimeTemoignage>
     */
    public function getAimeTemoignages(): Collection
    {
        return $this->aimeTemoignages;
    }

    public function addAimeTemoignage(AimeTemoignage $aimeTemoignage): self
    {
        if (!$this->aimeTemoignages->contains($aimeTemoignage)) {
            $this->aimeTemoignages->add($aimeTemoignage);
            $aimeTemoignage->setAimePar($this);
        }

        return $this;
    }

    public function removeAimeTemoignage(AimeTemoignage $aimeTemoignage): self
    {
        if ($this->aimeTemoignages->removeElement($aimeTemoignage)) {
            // set the owning side to null (unless already changed)
            if ($aimeTemoignage->getAimePar() === $this) {
                $aimeTemoignage->setAimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AdoreTemoignage>
     */
    public function getAdoreTemoignages(): Collection
    {
        return $this->adoreTemoignages;
    }

    public function addAdoreTemoignage(AdoreTemoignage $adoreTemoignage): self
    {
        if (!$this->adoreTemoignages->contains($adoreTemoignage)) {
            $this->adoreTemoignages->add($adoreTemoignage);
            $adoreTemoignage->setAdorePar($this);
        }

        return $this;
    }

    public function removeAdoreTemoignage(AdoreTemoignage $adoreTemoignage): self
    {
        if ($this->adoreTemoignages->removeElement($adoreTemoignage)) {
            // set the owning side to null (unless already changed)
            if ($adoreTemoignage->getAdorePar() === $this) {
                $adoreTemoignage->setAdorePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AimeCommentaire>
     */
    public function getAimeCommentaires(): Collection
    {
        return $this->aimeCommentaires;
    }

    public function addAimeCommentaire(AimeCommentaire $aimeCommentaire): self
    {
        if (!$this->aimeCommentaires->contains($aimeCommentaire)) {
            $this->aimeCommentaires->add($aimeCommentaire);
            $aimeCommentaire->setAimePar($this);
        }

        return $this;
    }

    public function removeAimeCommentaire(AimeCommentaire $aimeCommentaire): self
    {
        if ($this->aimeCommentaires->removeElement($aimeCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($aimeCommentaire->getAimePar() === $this) {
                $aimeCommentaire->setAimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AdoreCommentaire>
     */
    public function getAdoreCommentaires(): Collection
    {
        return $this->adoreCommentaires;
    }

    public function addAdoreCommentaire(AdoreCommentaire $adoreCommentaire): self
    {
        if (!$this->adoreCommentaires->contains($adoreCommentaire)) {
            $this->adoreCommentaires->add($adoreCommentaire);
            $adoreCommentaire->setAdorePar($this);
        }

        return $this;
    }

    public function removeAdoreCommentaire(AdoreCommentaire $adoreCommentaire): self
    {
        if ($this->adoreCommentaires->removeElement($adoreCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($adoreCommentaire->getAdorePar() === $this) {
                $adoreCommentaire->setAdorePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostProfil>
     */
    public function getPostProfils(): Collection
    {
        return $this->postProfils;
    }

    public function addPostProfil(PostProfil $postProfil): self
    {
        if (!$this->postProfils->contains($postProfil)) {
            $this->postProfils->add($postProfil);
            $postProfil->setAuteur($this);
        }

        return $this;
    }

    public function removePostProfil(PostProfil $postProfil): self
    {
        if ($this->postProfils->removeElement($postProfil)) {
            // set the owning side to null (unless already changed)
            if ($postProfil->getAuteur() === $this) {
                $postProfil->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommentairePostProfil>
     */
    public function getCommentairePostProfils(): Collection
    {
        return $this->commentairePostProfils;
    }

    public function addCommentairePostProfil(CommentairePostProfil $commentairePostProfil): self
    {
        if (!$this->commentairePostProfils->contains($commentairePostProfil)) {
            $this->commentairePostProfils->add($commentairePostProfil);
            $commentairePostProfil->setAuteur($this);
        }

        return $this;
    }

    public function removeCommentairePostProfil(CommentairePostProfil $commentairePostProfil): self
    {
        if ($this->commentairePostProfils->removeElement($commentairePostProfil)) {
            // set the owning side to null (unless already changed)
            if ($commentairePostProfil->getAuteur() === $this) {
                $commentairePostProfil->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Temoignage>
     */
    public function getTemoignagesSupprimes(): Collection
    {
        return $this->temoignagesSupprimes;
    }

    public function addTemoignagesSupprime(Temoignage $temoignagesSupprime): self
    {
        if (!$this->temoignagesSupprimes->contains($temoignagesSupprime)) {
            $this->temoignagesSupprimes->add($temoignagesSupprime);
            $temoignagesSupprime->setSupprimeBy($this);
        }

        return $this;
    }

    public function removeTemoignagesSupprime(Temoignage $temoignagesSupprime): self
    {
        if ($this->temoignagesSupprimes->removeElement($temoignagesSupprime)) {
            // set the owning side to null (unless already changed)
            if ($temoignagesSupprime->getSupprimeBy() === $this) {
                $temoignagesSupprime->setSupprimeBy(null);
            }
        }

        return $this;
    }

    public function getSloganDevise(): ?string
    {
        return $this->sloganDevise;
    }

    public function setSloganDevise(?string $sloganDevise): self
    {
        $this->sloganDevise = $sloganDevise;

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->setAuteur($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getAuteur() === $this) {
                $album->setAuteur(null);
            }
        }

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getAnimauxDeCompagnie(): ?string
    {
        return $this->animauxDeCompagnie;
    }

    public function setAnimauxDeCompagnie(?string $animauxDeCompagnie): self
    {
        $this->animauxDeCompagnie = $animauxDeCompagnie;

        return $this;
    }

    public function getLieuVacancePrefere(): ?string
    {
        return $this->lieuVacancePrefere;
    }

    public function setLieuVacancePrefere(?string $lieuVacancePrefere): self
    {
        $this->lieuVacancePrefere = $lieuVacancePrefere;

        return $this;
    }

    public function getStatutMatrimonial(): ?StatutMatrimonial
    {
        return $this->statutMatrimonial;
    }

    public function setStatutMatrimonial(?StatutMatrimonial $statutMatrimonial): self
    {
        $this->statutMatrimonial = $statutMatrimonial;

        return $this;
    }

    public function getFume(): ?CigaretteVin
    {
        return $this->fume;
    }

    public function setFume(?CigaretteVin $fume): self
    {
        $this->fume = $fume;

        return $this;
    }

    public function getBoisson(): ?CigaretteVin
    {
        return $this->boisson;
    }

    public function setBoisson(?CigaretteVin $boisson): self
    {
        $this->boisson = $boisson;

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

    /**
     * @return Collection<int, LangueMembre>
     */
    public function getLangueMembres(): Collection
    {
        return $this->langueMembres;
    }

    public function addLangueMembre(LangueMembre $langueMembre): self
    {
        if (!$this->langueMembres->contains($langueMembre)) {
            $this->langueMembres->add($langueMembre);
            $langueMembre->setMembre($this);
        }

        return $this;
    }

    public function removeLangueMembre(LangueMembre $langueMembre): self
    {
        if ($this->langueMembres->removeElement($langueMembre)) {
            // set the owning side to null (unless already changed)
            if ($langueMembre->getMembre() === $this) {
                $langueMembre->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Groupe>
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes->add($groupe);
            $groupe->setCreateur($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getCreateur() === $this) {
                $groupe->setCreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MembreGroupe>
     */
    public function getMembreGroupes(): Collection
    {
        return $this->membreGroupes;
    }

    public function addMembreGroupe(MembreGroupe $membreGroupe): self
    {
        if (!$this->membreGroupes->contains($membreGroupe)) {
            $this->membreGroupes->add($membreGroupe);
            $membreGroupe->setMembre($this);
        }

        return $this;
    }

    public function removeMembreGroupe(MembreGroupe $membreGroupe): self
    {
        if ($this->membreGroupes->removeElement($membreGroupe)) {
            // set the owning side to null (unless already changed)
            if ($membreGroupe->getMembre() === $this) {
                $membreGroupe->setMembre(null);
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
            $preference->setUser($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): self
    {
        if ($this->preferences->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getUser() === $this) {
                $preference->setUser(null);
            }
        }

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(?string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

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

    /**
     * @return Collection<int, MessageGroupe>
     */
    public function getMessageGroupes(): Collection
    {
        return $this->messageGroupes;
    }

    public function addMessageGroupe(MessageGroupe $messageGroupe): self
    {
        if (!$this->messageGroupes->contains($messageGroupe)) {
            $this->messageGroupes->add($messageGroupe);
            $messageGroupe->setAuteur($this);
        }

        return $this;
    }

    public function removeMessageGroupe(MessageGroupe $messageGroupe): self
    {
        if ($this->messageGroupes->removeElement($messageGroupe)) {
            // set the owning side to null (unless already changed)
            if ($messageGroupe->getAuteur() === $this) {
                $messageGroupe->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MessageGroupe>
     */
    public function getSupprimePar(): Collection
    {
        return $this->supprimePar;
    }

    public function addSupprimePar(MessageGroupe $supprimePar): self
    {
        if (!$this->supprimePar->contains($supprimePar)) {
            $this->supprimePar->add($supprimePar);
            $supprimePar->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimePar(MessageGroupe $supprimePar): self
    {
        if ($this->supprimePar->removeElement($supprimePar)) {
            // set the owning side to null (unless already changed)
            if ($supprimePar->getSupprimePar() === $this) {
                $supprimePar->setSupprimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AimeMessageGroupe>
     */
    public function getAimeMessageGroupes(): Collection
    {
        return $this->aimeMessageGroupes;
    }

    public function addAimeMessageGroupe(AimeMessageGroupe $aimeMessageGroupe): self
    {
        if (!$this->aimeMessageGroupes->contains($aimeMessageGroupe)) {
            $this->aimeMessageGroupes->add($aimeMessageGroupe);
            $aimeMessageGroupe->setAimePar($this);
        }

        return $this;
    }

    public function removeAimeMessageGroupe(AimeMessageGroupe $aimeMessageGroupe): self
    {
        if ($this->aimeMessageGroupes->removeElement($aimeMessageGroupe)) {
            // set the owning side to null (unless already changed)
            if ($aimeMessageGroupe->getAimePar() === $this) {
                $aimeMessageGroupe->setAimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AdoreMessageGroupe>
     */
    public function getAdoreMessageGroupes(): Collection
    {
        return $this->adoreMessageGroupes;
    }

    public function addAdoreMessageGroupe(AdoreMessageGroupe $adoreMessageGroupe): self
    {
        if (!$this->adoreMessageGroupes->contains($adoreMessageGroupe)) {
            $this->adoreMessageGroupes->add($adoreMessageGroupe);
            $adoreMessageGroupe->setAdorePar($this);
        }

        return $this;
    }

    public function removeAdoreMessageGroupe(AdoreMessageGroupe $adoreMessageGroupe): self
    {
        if ($this->adoreMessageGroupes->removeElement($adoreMessageGroupe)) {
            // set the owning side to null (unless already changed)
            if ($adoreMessageGroupe->getAdorePar() === $this) {
                $adoreMessageGroupe->setAdorePar(null);
            }
        }

        return $this;
    }

}
