<?php

namespace App\Controller;

use App\Repository\AmitieRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/invitations')]
class ListeInvitationController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected AmitieRepository $amitieRepository
        )
    {
    }

    #[Route('/liste-invitations', name: 'liste_invitations')]
    public function listeMembres(): Response
    {
        ////je récupère le user connecté
        /**
         * @var User
         */
        $user = $this->getUser();

        /////je recupères les invitations de cet utilisateur
        $invitations = $this->amitieRepository->findBy([
            "demandeA" => $user,
            "statut" => 1        
        ]);
        return $this->render('listeinvitations/listeInvitation.html.twig', [
            'membres' => $invitations,
        ]);
    }
}
