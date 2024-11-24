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
class InvitationGroupeController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected GroupeRepository $groupeRepository,
        protected GroupeInvitationService $groupeInvitationService)
    {}

    #[Route('/inviter-groupe/{groupeId}/{userId}', name: 'inviter_groupe', methods: ['POST'])]
    public function inviterGroupe(int $groupeId, int $userId): JsonResponse
    {
        $groupe = $this->groupeRepository->find($groupeId);
        
        $membreAinviter = $this->userRepository->find($userId);

        $currentUser = $this->getUser();

        $this->groupeInvitationService->envoyerInvitation($groupe, $membreAinviter);

        return new JsonResponse(['status' => 'success', 'message' => 'Invitation envoyée avec succès.']);

    }

}