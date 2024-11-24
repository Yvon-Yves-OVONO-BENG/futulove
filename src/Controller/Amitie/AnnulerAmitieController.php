<?php

namespace App\Controller\Amitie;

use App\Repository\AmitieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/amitie')]
class AnnulerAmitieController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected AmitieRepository $amitieRepository,
    ){}

    #[Route('/annuler-amitie/{id}', name: 'annuler_amitie', methods: ['POST'])]
    public function annulerAmitie(int $id): Response
    {
        ///je recupère la demande d'amitié
        $profil = $this->userRepository->find($id);
        $amitie = $this->amitieRepository->findOneBy([
            'demandePar' => $this->getUser(), 
            'demandeA' => $profil
        ]);
       
        $this->em->remove($amitie);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
    }
}
