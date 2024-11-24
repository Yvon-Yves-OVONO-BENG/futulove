<?php

namespace App\Controller\Commentaire;

use App\Entity\AdoreCommentaire;
use App\Entity\Commentaire;
use App\Repository\AdoreCommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/commentaire")]
class AdoreCommentaireController extends AbstractController
{
    #[Route("/adore-commentaire/{id}", name:"adore_commentaire", methods: ["POST"])]
    public function adoreCommentaire(Commentaire $commentaire, EntityManagerInterface $em, AdoreCommentaireRepository $adoreCommentaireRepository): JsonResponse
    {
        $user = $this->getUser();

        // Vérifier si l'utilisateur a déjà aimé ce commentaire
        $existingAdore = $adoreCommentaireRepository->findOneBy(['commentaire' => $commentaire, 'adorePar' => $user]);

        if ($existingAdore) 
        {
            $em->remove($existingAdore);
            $em->flush();
            $estAdore = false;
        } 
        else 
        {
            $adore = new AdoreCommentaire();
            $adore->setCommentaire($commentaire);
            $adore->setAdorePar($user);
            $em->persist($adore);
            $em->flush();
            $estAdore = true;
        }

        // Retourner une réponse JSON avec le nombre actuel de likes
        return new JsonResponse([
            'estAdore' => $estAdore,
            'likeCount' => count($commentaire->getAdoreCommentaires())
        ]);
    }
}