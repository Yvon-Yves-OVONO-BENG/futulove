<?php

namespace App\Controller\Groupe;

use App\Repository\GroupeRepository;
use App\Repository\UserRepository;
use App\Service\GroupeInvitationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/groupe')]
class AccepterInvitationGroupeController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected GroupeRepository $groupeRepository,
        protected GroupeInvitationService $groupeInvitationService)
    {}

    #[Route('/accepter-invitation-groupe/{groupeId}/{userId}', name: 'accepter_invitation_groupe')]
    public function annulerInvitation(int $groupeId, int $userId): JsonResponse
    {
        $groupe = $this->groupeRepository->find($groupeId);

        $membreAannuler = $this->userRepository->find($userId);

        $currentUser = $this->getUser();

        $this->groupeInvitationService->accepterInvitationGroupe($groupe, $membreAannuler, $currentUser);

        return new JsonResponse(['status' => 'success', 'message' => 'Invitation acceptée avec succès.']);
    }
}