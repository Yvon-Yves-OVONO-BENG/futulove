<?php

namespace App\Controller\Compte;

use App\Repository\AmitieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class BloquerCompteController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected AmitieRepository $amitieRepository
    )
    {}

    #[Route('/bloquer-compte/{idCompte}', name: 'bloquer_compte')]
    public function bloquerCompte(int $idCompte): Response
    {
        $user = $this->getUser();

        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Vous n'êtes pas autorisé(e) à bloquer ce compte"
        ], 403);

        ////////je vérifie si l'amitié existe déjà
        $compte = $this->userRepository->find($idCompte);

        $amitieBloque = $this->amitieRepository->rechercheAmitieBloque($user, $compte);
        
        // dd($amitieBloque[0]->isBloque());
        if ($amitieBloque[0]->isBloque() == 1) 
        {
            $amitieBloque = $amitieBloque[0];

            $amitieBloque->setBloque(0);
            $this->em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Amitié débloquée avec succès ! '
            ], 200);
        }
        else
        {
            $amitieBloque = $amitieBloque[0];
            $amitieBloque->setBloque(1);

            $this->em->persist($amitieBloque);
            $this->em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Amitié bloqué avec succès ! '
            ], 200);
        }
    }
}
