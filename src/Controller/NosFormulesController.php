<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NosFormulesController extends AbstractController
{
    #[Route('/nos-formules', name: 'nos_formules')]
    public function nosFormules(): Response
    {
        return $this->render('nos_formules/nosFormules.html.twig', [
        ]);
    }
}
