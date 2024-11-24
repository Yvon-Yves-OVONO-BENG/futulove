<?php

namespace App\Controller\Compte;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class SuspendreCompteController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
    )
    {}

    #[Route('/suspendre-compte/{idCompte}', name: 'suspendre_compte')]
    public function suspendreCompte(int $idCompte): Response
    {
        $user = $this->getUser();

        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Vous n'êtes pas suspendre ce compte"
        ], 403);

        $compte = $this->userRepository->find($idCompte);

        if ($compte->isSuspendu() == 1) 
        {
            $compte->setSuspendu(0);
            $this->em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Compte activé avec succès ! '
            ], 200);
        }
        else
        {
            $compte->setSuspendu(1);

            $this->em->persist($compte);
            $this->em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Compte suspendu avec succès ! '
            ], 200);
        }
    }
}
