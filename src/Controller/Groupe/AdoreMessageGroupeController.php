<?php

namespace App\Controller\Groupe;

use App\Entity\AdoreMessageGroupe;
use App\Entity\MessageGroupe;
use App\Repository\AdoreMessageGroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/groupe")]
class AdoreMessageGroupeController extends AbstractController
{
    #[Route("/adore-message-groupe/{id}", name:"adore_message_groupe", methods: ["POST"])]
    public function adoreMessageGroupe(MessageGroupe $messageGroupe, EntityManagerInterface $em, AdoreMessageGroupeRepository $adoreMessageGroupeRepository): JsonResponse
    {
        $user = $this->getUser();

        // Vérifier si l'utilisateur a déjà aimé ce messageGroupe
        $existingAdore = $adoreMessageGroupeRepository->findOneBy(['messageGroupe' => $messageGroupe, 'adorePar' => $user]);

        if ($existingAdore) 
        {
            $em->remove($existingAdore);
            $em->flush();
            $estAdore = false;
        } 
        else 
        {
            $adore = new AdoreMessageGroupe();
            $adore->setMessageGroupe($messageGroupe);
            $adore->setAdorePar($user);
            $em->persist($adore);
            $em->flush();
            $estAdore = true;
        }

        // Retourner une réponse JSON avec le nombre actuel de likes
        return new JsonResponse([
            'success' => 'success',
            'estAdore' => $estAdore,
            'likeCount' => count($messageGroupe->getAdoreMessageGroupes())
        ]);
    }
}