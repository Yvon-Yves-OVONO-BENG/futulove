<?php

namespace App\Controller\Groupe;

use App\Entity\AimeMessageGroupe;
use App\Entity\MessageGroupe;
use App\Repository\AimeMessageGroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/groupe")]
class AimeMessageGroupeController extends AbstractController
{
    #[Route("/aime-message-groupe/{id}", name:"aime_message_groupe", methods: ["POST"])]
    public function aimeMessageGroupe(MessageGroupe $messageGroupe, EntityManagerInterface $em, AimeMessageGroupeRepository $aimeMessageGroupeRepository): JsonResponse
    {
        $user = $this->getUser();

        // Vérifier si l'utilisateur a déjà aimé ce messageGroupe
        $existingAime = $aimeMessageGroupeRepository->findOneBy(['messageGroupe' => $messageGroupe, 'aimePar' => $user]);

        if ($existingAime) 
        {
            $em->remove($existingAime);
            $em->flush();
            $estAime = false;
        } 
        else 
        {
            $like = new AimeMessageGroupe();
            $like->setMessageGroupe($messageGroupe);
            $like->setAimePar($user);
            $em->persist($like);
            $em->flush();
            $estAime = true;
        }

        // Retourner une réponse JSON avec le nombre actuel de likes
        return new JsonResponse([
            'success' => 'success',
            'estAime' => $estAime,
            'likeCount' => count($messageGroupe->getAimeMessageGroupes())
        ]);
    }
}