<?php

namespace App\Controller\MessagePrive;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class ModifierMassagePriveController extends AbstractController
{
    #[Route('/modifier/massage/prive', name: 'app_modifier_massage_prive')]
    public function index(): Response
    {
        return $this->render('modifier_massage_prive/index.html.twig', [
            'controller_name' => 'ModifierMassagePriveController',
        ]);
    }
}
