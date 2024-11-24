<?php

namespace App\Controller\Signalement;

use DateTime;
use App\Repository\UserRepository;
use App\Repository\SignalementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/signalement')]
class DesignalerController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected SignalementRepository $signalementRepository,
    ){}

    #[Route('/designaler/{id}', name: 'designaler', methods: ['POST'])]
    public function designalement(int $id): Response
    {
        if (!$this->getUser()) return $this->json([
            'code' => 403,
            'message' => "Vous n'êtes pas autorisé(e) à faire cette demande d'amitié"
        ], 403);
        
        $profil = $this->userRepository->find($id);

        $signalement = $this->signalementRepository->findOneBy([
            'signalePar' => $this->getUser(),
            'compteSignale' => $profil,
        ]);
        
        $signalement->setCompteSignale($profil)
                ->setSignalePar($this->getUser())
                ->setEtatSignalement(0)
                ->setDateDesignalementAt(new DateTime('now'))
                ;

        $this->em->persist($signalement);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
        

    }
}
