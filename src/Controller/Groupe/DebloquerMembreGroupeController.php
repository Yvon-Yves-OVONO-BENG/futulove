<?php

namespace App\Controller\Groupe;

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
class DebloquerMembreGroupeController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected GroupeRepository $groupeRepository,
        protected MembreGroupeRepository $membreGroupeRepository,
    ){}

    #[Route('/debloquer-membre-groupe/{id}', name: 'debloquer_membre_groupe')]
    public function debloquerMembreGroupe(int $id): Response
    {
        $membreGroupe = $this->membreGroupeRepository->find($id);
        
        if ($membreGroupe->isBloque() == 1) 
        {
            $membreGroupe->setBloque(0);
        } 
        else 
        {
            $membreGroupe->setBloque(1);
        }

        $this->em->persist($membreGroupe);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
    
    }
}
