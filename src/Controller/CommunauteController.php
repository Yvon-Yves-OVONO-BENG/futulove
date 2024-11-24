<?php

namespace App\Controller;

use App\Repository\GroupeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommunauteController extends AbstractController
{
    public function __construct(
        protected GroupeRepository $groupeRepository
    ){}

    #[Route('/communaute', name: 'communaute')]
    public function communaute(): Response
    {
        $groupes = $this->groupeRepository->findBy([
            "supprime" => 0
        ]);

        return $this->render('communaute/communaute.html.twig', [
            "groupes" => $groupes
        ]);
    }
}
