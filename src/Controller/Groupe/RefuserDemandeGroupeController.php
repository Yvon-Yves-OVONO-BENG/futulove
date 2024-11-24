<?php

namespace App\Controller\Groupe;

use DateTime;
use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use App\Repository\GroupeRepository;
use App\Repository\MembreGroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/groupe')]
class RefuserDemandeGroupeController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected GroupeRepository $groupeRepository,
        protected MembreGroupeRepository $membreGroupeRepository,
    ){}

    #[Route('/refuser-demande-groupe/{id}', name: 'refuser_demande_groupe')]
    public function refuserDemandeGroupe(int $id): Response
    {
        $membreGroupe = $this->membreGroupeRepository->find($id);

        $this->em->remove($membreGroupe);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
    
    }
}
