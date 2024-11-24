<?php

namespace App\Service;

use App\Entity\Groupe;
use App\Entity\MembreGroupe;
use App\Entity\User;
use App\Repository\MembreGroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class GroupeInvitationService
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected MembreGroupeRepository $membreGroupeRepository,
        )
    {}

    /**
     * Envoyer une invitation à un utilisateur pour rejoindre un groupe.
     *
     * @param Groupe $groupe
     * @param User $membreAinviter
     * @param User $currentUser
     * @throws AccessDeniedException
     */
    public function envoyerInvitation(Groupe $groupe, User $membreAinviter): void
    {
        // if ($groupe->getCreateur() !== $currentUser) {
        //     throw new AccessDeniedException('Vous n\'êtes pas autorisé à inviter des utilisateurs dans ce groupe.');
        // }

        // if ($this->estDejaInvite($groupe, $membreAinviter)) {
        //     throw new \LogicException('L\'utilisateur a déjà été invité.');
        // }
        
        $invitation = new MembreGroupe();
        
        $invitation->setGroupe($groupe)
        ->setMembre($membreAinviter)
        ->setDateDemandeAt(new \DateTime())
        ->setEtatDemande(0)
        ->setBloque(0)
        ->setInvitation(1)
        ->setSupprime(0);

        $this->em->persist($invitation);
        $this->em->flush();
    }

    /**
     * Vérifie si un utilisateur a déjà été invité dans un groupe.
     *
     * @param Groupe $groupe
     * @param User $membreAinviter
     * @return bool
     */
    public function estDejaInvite(Groupe $groupe, User $membreAinviter): bool
    {
        $invitation = $this->membreGroupeRepository
            ->findOneBy(['group' => $groupe, 'membre' => $membreAinviter]);

        return $invitation !== null;
    }

    /**
     * Annuler une invitation.
     *
     * @param Groupe $groupe
     * @param User $membreAinviter
     * @param User $currentUser
     */
    public function annulerInvitation(Groupe $groupe, User $membreAannuler): void
    {
        $invitation = $this->membreGroupeRepository
            ->findOneBy(['groupe' => $groupe, 'membre' => $membreAannuler]);

        // if (!$invitation) {
        //     throw new \LogicException('Aucune invitation trouvée pour cet utilisateur.');
        // }

        // if ($invitation->getGroupe()->getCreateur() !== $currentUser) {
        //     throw new AccessDeniedException('Vous n\'êtes pas autorisé à annuler cette invitation.');
        // }

        $this->em->remove($invitation);
        $this->em->flush();
    }

     /**
     * Accepter une invitation d'un groupe.
     *
     * @param Groupe $groupe
     * @param User $membreAinviter
     * @param User $currentUser
     */
    public function accepterInvitationGroupe(Groupe $groupe, User $membre, User $currentUser): void
    {
        $invitation = $this->membreGroupeRepository
            ->findOneBy(['groupe' => $groupe, 'membre' => $membre]);

        // if (!$invitation) {
        //     throw new \LogicException('Aucune invitation trouvée pour cet utilisateur.');
        // }

        // if ($invitation->getGroupe()->getCreateur() !== $currentUser) {
        //     throw new AccessDeniedException('Vous n\'êtes pas autorisé à annuler cette invitation.');
        // }

        $invitation->setEtatDemande(1);
        $invitation->setInvitation(0);
        $this->em->persist($invitation);
        $this->em->flush();
    }
}