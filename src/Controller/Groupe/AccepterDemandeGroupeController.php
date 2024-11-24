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
class AccepterDemandeGroupeController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected GroupeRepository $groupeRepository,
        protected MembreGroupeRepository $membreGroupeRepository,
    ){}

    #[Route('/accepter-demande-groupe/{id}', name: 'accepter_demande_groupe')]
    public function accepterDemandeGroupe(int $id): Response
    {
        $membreGroupe = $this->membreGroupeRepository->find($id);
        
        $membreGroupe->setEtatDemande(1)
                ->setAjouteLeAt(new DateTime('now'));

        $this->em->persist($membreGroupe);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
    

    }
}
