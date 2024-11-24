<?php

namespace App\Controller\Administration;

use App\Repository\UserRepository;
use App\Repository\FormuleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMINISTRATEUR', message: 'Accès refusé. Connectez-vous')]
class CompteVipsController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected FormuleRepository $formuleRepository,
    ){}

    #[Route('/compte-vips', name: 'compte_vips')]
    public function compteVips(): Response
    {
        //je récupère les compte VIP
        $vip = $this->formuleRepository->find(4) ;
        $comptes = $this->userRepository->findBy([
            'formule' => $vip
        ]); 

        return $this->render('tableau_de_bord/compte.html.twig', [
            'comptes' => $comptes,
        ]);
    }
}
