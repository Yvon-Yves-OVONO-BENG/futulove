<?php

namespace App\Controller\MessagePrive;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]

class AfficherMessagePriveController extends AbstractController
{
    #[Route('/afficher/message/prive', name: 'app_afficher_message_prive')]
    public function index(): Response
    {
        return $this->render('afficher_message_prive/index.html.twig', [
            'controller_name' => 'AfficherMessagePriveController',
        ]);
    }
}
