<?php

namespace App\Controller\Signalement;

use DateTime;
use App\Entity\Signalement;
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
class SignalerController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected SignalementRepository $signalementRepository,
    ){}

    #[Route('/signaler/{id}', name: 'signaler', methods: ['POST'])]
    public function ajoutSignalement(int $id): Response
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

        if ($signalement) 
        {
            $signalement->setCompteSignale($profil)
                ->setSignalePar($this->getUser())
                ->setEtatSignalement(1)
                ->setDateSignalementAt(new DateTime('now'));
        } 
        else 
        {
            $signalement = new Signalement();

            $signalement->setCompteSignale($profil)
                ->setSignalePar($this->getUser())
                ->setEtatSignalement(1)
                ->setDateSignalementAt(new DateTime('now'));
        }
        
        $this->em->persist($signalement);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
        
    }
}
