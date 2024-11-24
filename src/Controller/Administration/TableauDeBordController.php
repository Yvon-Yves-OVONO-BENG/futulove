<?php

namespace App\Controller\Administration;

use App\Repository\UserRepository;
use App\Repository\FormuleRepository;
use App\Repository\SignalementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMINISTRATEUR', message: 'Accès refusé. Connectez-vous')]
class TableauDeBordController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected FormuleRepository $formuleRepository,
        protected SignalementRepository $signalementRepository
    ){}

    #[Route('/tableau-de-bord', name: 'tableau_de_bord')]
    public function tableauDeBord(): Response
    {
        //je récupère les comptes gratuits
        $gratuit = $this->formuleRepository->find(1) ;
        $compteGratuits = $this->userRepository->findBy([
            'formule' => $gratuit
        ]);

        //je récupère les compte premium
        $premium = $this->formuleRepository->find(2) ;
        $comptePremiums = $this->userRepository->findBy([
            'formule' => $premium
        ]);

        //je récupère les compte VIP
        $vip = $this->formuleRepository->find(4) ;
        $compteVips = $this->userRepository->findBy([
            'formule' => $vip
        ]); 

        //je récupère les comptes signalés
        $compteSignales = $this->userRepository->compteSignales();

        return $this->render('tableau_de_bord/tableauDeBord.html.twig', [
            'compteGratuits' => $compteGratuits,
            'comptePremiums' => $comptePremiums,
            'compteVips' => $compteVips,
            'compteSignales' => $compteSignales,
        ]);
    }
}
