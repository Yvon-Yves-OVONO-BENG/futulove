<?php

namespace App\Controller\Groupe;

use App\Repository\FichierMessageGroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/groupe')]
class SupprimerFichierMessageGroupeController extends AbstractController
{
    public function __construct(
        protected RequestStack $request,
        protected EntityManagerInterface $em,
        protected FichierMessageGroupeRepository $fichierMessageGroupeRepository,
    )
    {}

    #[Route('/supprimer-fichier-message-groupe/{slugFichierMessageGroupe}/{slugGroupe}', name: 'supprimer_fichier_message_groupe')]
    public function supprimerFichierMessageGroupe(Request $request, string $slugFichierMessageGroupe, string $slugGroupe): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('misAjour', null);
        $maSession->set('suppression', null);
        
        $fichierMessageGroupe = $this->fichierMessageGroupeRepository->findOneBySlug(['slug' => $slugFichierMessageGroupe ]);
       
        $fichierMessageGroupe->setSupprime(1);
        
        #je prépare ma requête à la suppression
        $this->em->persist($fichierMessageGroupe);

        #j'exécute ma requête
        $this->em->flush();

        #je retourne au profil
        return $this->redirectToRoute('afficher_groupe', [ 'slug' => $slugGroupe ]);
    }
}
