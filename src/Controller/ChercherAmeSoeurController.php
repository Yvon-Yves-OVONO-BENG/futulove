<?php

namespace App\Controller;

use App\Entity\ConstantsClass;
use App\Repository\AgeRepository;
use App\Repository\PaysRepository;
use App\Repository\SexeRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

// #[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class ChercherAmeSoeurController extends AbstractController
{
    public function __construct(
        protected AgeRepository $ageRepository,
        protected PaysRepository $paysRepository,
        protected SexeRepository $sexeRepository,
        protected UserRepository $userRepository,
    )
    {}

    #[Route('/chercher-ame-soeur', name: 'chercher_ame_soeur')]
    public function chercherAmeSoeur(Request $request): Response
    {
        
        ///je récupères les âges
        $ages = $this->ageRepository->findAll();
        $pays = $this->paysRepository->findAll();
        $sexes = $this->sexeRepository->findAll();

       if ($request->request->has('chercher')) 
       {
            $membres = [];
            $sexe = $this->sexeRepository->find($request->request->get('sexe'));

            $ageMinimum = 0; 
            $ageLimite = 0;
            
            if ($request->request->get('ageMinimum') != null) 
            {
                $ageMinimum = (int)$this->ageRepository->find($request->request->get('ageMinimum'))->getAge();
            }

            if ($request->request->get('ageLimite') != null) 
            {
                $ageLimite = (int)$this->ageRepository->find($request->request->get('ageLimite'))->getAge();
            }
            
            $pay = $this->paysRepository->find($request->request->get('pays'));
            
            $membre = $this->userRepository->jeChercheMonAmeSoeur($sexe, $ageMinimum, $ageLimite, $pay);
            
            foreach ($membre as $membr) 
            {
                if (!(in_array(ConstantsClass::ROLE_ADMINISTRATEUR, $membr->getRoles())))
                {
                    $membres[] = $membr;
                }
            }
            
            return $this->render('chercher_ame_soeur/resultatRecherche.html.twig', [
                "ages" => $ages,
                "pays" => $pays,
                "sexes" => $sexes,
                'membres' => $membres,
                'rechercheMembre' => true,
                'tousLesMembres' => false,
            ]);
       }

        
    }
}
