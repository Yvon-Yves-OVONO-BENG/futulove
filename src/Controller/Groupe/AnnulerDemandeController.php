<?php

namespace App\Controller\Groupe;

use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MembreGroupeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/groupe')]
class AnnulerDemandeController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected GroupeRepository $groupeRepository,
        protected AmitieRepository $amitieRepository,
        protected MembreGroupeRepository $membreGroupeRepository,
    ){}

    #[Route('/annuler-demande/{id}', name: 'annuler_demande', methods: ['POST'])]
    public function annulerDemande(int $id): Response
    {
        ////////je écupère le groupe
        $groupe = $this->groupeRepository->find($id);

        $membreGroupe = $this->membreGroupeRepository->findOneBy([
            'membre' => $this->getUser(),
            'groupe' => $groupe,
        ]);
        
        $this->em->remove($membreGroupe);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
    }
}
