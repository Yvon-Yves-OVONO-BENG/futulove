<?php

namespace App\Controller\Administration;

use App\Repository\UserRepository;
use App\Repository\FormuleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMINISTRATEUR', message: 'Accès refusé. Connectez-vous')]
class ComptePremiumsController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected FormuleRepository $formuleRepository,
    ){}
    
    #[Route('/compte-premiums', name: 'compte_premiums')]
    public function comptePremiums(): Response
    {
        //je récupère les compte premium
        $premium = $this->formuleRepository->find(2) ;
        $comptes = $this->userRepository->findBy([
            'formule' => $premium
        ]);

        return $this->render('tableau_de_bord/compte.html.twig', [
            'comptes' => $comptes
        ]);
    }
}
