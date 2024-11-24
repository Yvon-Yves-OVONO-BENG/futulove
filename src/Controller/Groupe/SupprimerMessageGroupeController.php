<?php

namespace App\Controller\Groupe;

use App\Repository\MessageGroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/groupe')]
class SupprimerMessageGroupeController extends AbstractController
{
    public function __construct(
        protected RequestStack $request,
        protected EntityManagerInterface $em,
        protected MessageGroupeRepository $messageGroupeRepository,
    )
    {}

    #[Route('/supprimer-message-groupe/{slugMessageGroupe}/{slugGroupe}', name: 'supprimer_message_groupe')]
    public function supprimerMessageGroupe(Request $request, string $slugMessageGroupe, string $slugGroupe): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('misAjour', null);
        $maSession->set('suppression', null);
        
        $messageGroupe = $this->messageGroupeRepository->findOneBySlug(['slug' => $slugMessageGroupe ]);
       
        $messageGroupe->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new \DateTime());
        
        #je prépare ma requête à la suppression
        $this->em->persist($messageGroupe);

        #j'exécute ma requête
        $this->em->flush();

        #je retourne au profil
        return $this->redirectToRoute('afficher_groupe', [ 'slug' => $slugGroupe ]);
    }
}
