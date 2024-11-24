<?php

namespace App\Controller\Temoignage;

use App\Entity\AimeTemoignage;
use App\Entity\Temoignage;
use App\Repository\AimeTemoignageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/temoignage")]
class AimeTemoignageController extends AbstractController
{
    #[Route("/aime-temoignage/{id}", name:"aime_temoignage", methods: ["POST"])]
    public function aimeTemoignage(Temoignage $temoignage, EntityManagerInterface $em, AimeTemoignageRepository $likeRepository): JsonResponse
    {
        $user = $this->getUser();

        // Vérifier si l'utilisateur a déjà aimé ce temoignage
        $existingAime = $likeRepository->findOneBy(['temoignage' => $temoignage, 'aimePar' => $user]);

        if ($existingAime) 
        {
            $em->remove($existingAime);
            $em->flush();
            $estAime = false;
        } 
        else 
        {
            $like = new AimeTemoignage();
            $like->setTemoignage($temoignage);
            $like->setAimePar($user);
            $em->persist($like);
            $em->flush();
            $estAime = true;
        }

        // Retourner une réponse JSON avec le nombre actuel de likes
        return new JsonResponse([
            'estAime' => $estAime,
            'likeCount' => count($temoignage->getAimeTemoignages())
        ]);
    }
}