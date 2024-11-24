<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermesEtConditionsController extends AbstractController
{
    #[Route('/termes-et-conditions', name: 'termes_et_conditions')]
    public function termesEtConditions(): Response
    {
        return $this->render('termes_et_conditions/termesEtConditions.html.twig', [
        ]);
    }
}
