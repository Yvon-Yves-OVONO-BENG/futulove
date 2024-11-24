<?php

namespace App\Controller\Compte;

use App\Entity\Signalement;
use App\Repository\SignalementRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class SignalerCompteController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected SignalementRepository $signalementRepository
    )
    {}

    #[Route('/signaler-compte/{idCompte}', name: 'signaler_compte')]
    public function signalerCompte(int $idCompte): Response
    {
        //je récupère l'utilisateur connecté
        /**
         * @var User
         */
        $signalePar = $this->getUser();

        ////si l'utilisateur n'existe pas
        if (!$signalePar) 
            return $this->json([
                'code' => 403,
                'message' => "Vous n'êtes pas autorisé(e) à signaler ce compte"
            ], 403);

        $signalePar = $this->userRepository->find($signalePar->getId());

        $compteSignale = $this->userRepository->find($idCompte);

        $signalement = $this->signalementRepository->findOneBy([
            'signalePar' => $signalePar,
            'compteSignale' => $compteSignale
        ]);

        if ($signalement) 
        {
            $this->em->remove($signalement);
            $this->em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Signalement annulée avec succès ! '
            ], 200);
        }
        else 
        {
            $signalement = new Signalement;

            $signalement
                ->setSignalePar($signalePar)
                ->setCompteSignale($compteSignale)
            ;

            $this->em->persist($signalement);
            $this->em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Compte signalé avec succès ! '
            ], 200);
        }

        
    }
}
