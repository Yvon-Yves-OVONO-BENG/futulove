<?php

namespace App\Controller\Amitie;

use DateTime;
use App\Entity\Amitie;
use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/amitie')]
class DemandeAmitieController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository
    ){}

    #[Route('/demande-amitie/{id}', name: 'demande_amitie', methods: ['POST'])]
    public function demandeAmitie(AmitieRepository $amitieRepository, int $id): Response
    {
        if (!$this->getUser()) return $this->json([
            'code' => 403,
            'message' => "Vous n'êtes pas autorisé(e) à faire cette demande d'amitié"
        ], 403);

        ////////je vérifie si l'amitié existe déjà
        $profil = $this->userRepository->find($id);

        $amitie = $amitieRepository->findOneBy([
            'demandePar' => $this->getUser(),
            'demandeA' => $profil,
        ]);
        
        if ($amitie) 
        {
            $this->em->remove($amitie);
            $this->em->flush();

            return new JsonResponse(['success' => true]);
        }
        else
        {
            $amitie = new Amitie();
            $amitie->setDemandePar($this->getUser())
                    ->setDemandeA($profil)
                    ->setStatut(1)
                    ->setDemandeLeAt(new DateTime('now'))
                    ->setBloque(0)
                    ;

            $this->em->persist($amitie);
            $this->em->flush();

            return new JsonResponse(['success' => true]);
        }

    }
}
