<?php

namespace App\Controller\Favori;

use DateTime;
use App\Repository\UserRepository;
use App\Repository\FavoriRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/favori')]
class SupprimerFavoriController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected FavoriRepository $favoriRepository,
    ){}

    #[Route('/supprimer-favori/{id}', name: 'supprimer_favori', methods: ['POST'])]
    public function supprimerFavori(int $id): Response
    {
        if (!$this->getUser()) return $this->json([
            'code' => 403,
            'message' => "Vous n'êtes pas autorisé(e) à faire cette demande d'amitié"
        ], 403);
        
        $profil = $this->userRepository->find($id);

        $favori = $this->favoriRepository->findOneBy([
            'moi' => $this->getUser(),
            'favori' => $profil,
        ]);
        
        $favori->setFavori($profil)
                ->setMoi($this->getUser())
                ->setEtatFavori(0)
                ->setDateSuppressionFavoriAt(new DateTime('now'))
                ;

        $this->em->persist($favori);
        $this->em->flush();

        return new JsonResponse(['success' => true]);
        

    }
}
