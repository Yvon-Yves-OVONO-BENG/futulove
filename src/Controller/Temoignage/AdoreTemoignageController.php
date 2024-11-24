<?php

namespace App\Controller\Temoignage;

use App\Entity\AdoreTemoignage;
use App\Entity\Temoignage;
use App\Repository\AdoreTemoignageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/temoignage")]
class AdoreTemoignageController extends AbstractController
{
    #[Route("/adore-temoignage/{id}", name:"adore_temoignage", methods: ["POST"])]
    public function adoreTemoignage(Temoignage $temoignage, EntityManagerInterface $em, AdoreTemoignageRepository $adoreTemoignageRepository): JsonResponse
    {
        $user = $this->getUser();

        // Vérifier si l'utilisateur a déjà aimé ce temoignage
        $existingAdore = $adoreTemoignageRepository->findOneBy(['temoignage' => $temoignage, 'adorePar' => $user]);

        if ($existingAdore) 
        {
            $em->remove($existingAdore);
            $em->flush();
            $estAdore = false;
        } 
        else 
        {
            $adore = new AdoreTemoignage();
            $adore->setTemoignage($temoignage);
            $adore->setAdorePar($user);
            $em->persist($adore);
            $em->flush();
            $estAdore = true;
        }

        // Retourner une réponse JSON avec le nombre actuel de likes
        return new JsonResponse([
            'estAdore' => $estAdore,
            'likeCount' => count($temoignage->getAdoreTemoignages())
        ]);
    }
}