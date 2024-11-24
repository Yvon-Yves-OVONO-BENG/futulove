<?php

namespace App\Controller\Commentaire;

use App\Entity\AimeCommentaire;
use App\Entity\Commentaire;
use App\Repository\AimeCommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/commentaire")]
class AimeCommentaireController extends AbstractController
{
    #[Route("/aime-commentaire/{id}", name:"aime_commentaire", methods: ["POST"])]
    public function aimeCommentaire(Commentaire $commentaire, EntityManagerInterface $em, AimeCommentaireRepository $likeRepository): JsonResponse
    {
        $user = $this->getUser();

        // Vérifier si l'utilisateur a déjà aimé ce commentaire
        $existingAime = $likeRepository->findOneBy(['commentaire' => $commentaire, 'aimePar' => $user]);

        if ($existingAime) 
        {
            $em->remove($existingAime);
            $em->flush();
            $estAime = false;
        } 
        else 
        {
            $like = new AimeCommentaire();
            $like->setCommentaire($commentaire);
            $like->setAimePar($user);
            $em->persist($like);
            $em->flush();
            $estAime = true;
        }

        // Retourner une réponse JSON avec le nombre actuel de likes
        return new JsonResponse([
            'estAime' => $estAime,
            'likeCount' => count($commentaire->getAimeCommentaires())
        ]);
    }
}