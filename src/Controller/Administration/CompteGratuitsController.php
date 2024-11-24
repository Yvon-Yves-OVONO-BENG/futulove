<?php

namespace App\Controller\Administration;

use App\Repository\UserRepository;
use App\Repository\FormuleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMINISTRATEUR', message: 'Accès refusé. Connectez-vous')]
class CompteGratuitsController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected FormuleRepository $formuleRepository,
    ){}

    #[Route('/compte-gratuits', name: 'compte_gratuits')]
    public function compteGratuits(): Response
    {
        //je récupère les comptes gratuits
        $gratuit = $this->formuleRepository->find(1) ;
        $comptes = $this->userRepository->findBy([
            'formule' => $gratuit
        ]);

        return $this->render('tableau_de_bord/compte.html.twig', [
            'comptes' => $comptes
        ]);
    }
}
