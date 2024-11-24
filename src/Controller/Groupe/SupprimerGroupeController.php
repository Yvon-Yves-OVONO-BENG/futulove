<?php

namespace App\Controller\Groupe;

use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/groupe')]
class SupprimerGroupeController extends AbstractController
{
    public function __construct(
        protected RequestStack $request,
        protected EntityManagerInterface $em,
        protected GroupeRepository $groupeRepository,
    )
    {}

    #[Route('/supprimer-groupe/{id}', name: 'supprimer_groupe')]
    public function supprimerGroupe(Request $request, int $id): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('misAjour', null);
        $maSession->set('suppression', null);
        
        $groupe = $this->groupeRepository->find($id);
       
        $groupe->setSupprime(1);
        
        #je prépare ma requête à la suppression
        $this->em->persist($groupe);

        #j'exécute ma requête
        $this->em->flush();

        #je retourne au profil
        return $this->redirectToRoute('afficher_profil');
    }
}
