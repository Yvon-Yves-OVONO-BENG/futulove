<?php

namespace App\Controller\Groupe;

use DateTime;
use App\Entity\MembreGroupe;
use App\Repository\UserRepository;
use App\Repository\GroupeRepository;
use App\Repository\MembreGroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/groupe')]
class DemandeAjoutGroupeController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected GroupeRepository $groupeRepository,
        protected MembreGroupeRepository $membreGroupeRepository,
    ){}

    #[Route('/demande-ajout-groupe/{id}', name: 'demande_ajout_groupe', methods: ['POST'])]
    public function demandeAjoutGroupe(int $id): Response
    {
        if (!$this->getUser()) return $this->json([
            'code' => 403,
            'message' => "Vous n'êtes pas autorisé(e) à faire cette demande d'amitié"
        ], 403);

        ////////je écupère le groupe
        $groupe = $this->groupeRepository->find($id);

        $membreGroupe = $this->membreGroupeRepository->findOneBy([
            'membre' => $this->getUser(),
            'groupe' => $groupe,
        ]);
        
        if ($membreGroupe) 
        {
            $this->em->remove($membreGroupe);
            $this->em->flush();

            return new JsonResponse(['success' => true]);
        }
        else
        {
            $membreGroupe = new MembreGroupe();
            $membreGroupe->setMembre($this->getUser())
                    ->setGroupe($groupe)
                    ->setEtatDemande(0)
                    ->setBloque(0)
                    ->setDateDemandeAt(new DateTime('now'))
                    ->setSupprime(0)
                    ->setdemande(1)
                    ;

            $this->em->persist($membreGroupe);
            $this->em->flush();

            return new JsonResponse(['success' => true]);
        }

    }
}
