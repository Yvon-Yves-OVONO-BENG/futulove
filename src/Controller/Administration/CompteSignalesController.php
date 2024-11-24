<?php

namespace App\Controller\Administration;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMINISTRATEUR', message: 'Accès refusé. Connectez-vous')]
class CompteSignalesController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
    ){}

    #[Route('/compte-signales', name: 'compte_signales')]
    public function compteSignales(): Response
    {
        //je récupère les comptes signalés
        $comptes = $this->userRepository->compteSignales();
        
        return $this->render('tableau_de_bord/compte.html.twig', [
            'comptes' => $comptes,
        ]);
    }
}
