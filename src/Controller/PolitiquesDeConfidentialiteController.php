<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolitiquesDeConfidentialiteController extends AbstractController
{
    #[Route('/politiques-de-confidentialite', name: 'politiques_de_confidentialite')]
    public function politiquesDeConfidentialites(): Response
    {
        return $this->render('politiques_de_confidentialite/politiquesDeConfidentialite.html.twig', [
            
        ]);
    }
}
