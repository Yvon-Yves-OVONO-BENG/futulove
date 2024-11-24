<?php

namespace App\Controller\Profil;

use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/profil')]
class SupprimerAlbumController extends AbstractController
{
    public function __construct(
        protected RequestStack $request,
        protected EntityManagerInterface $em,
        protected AlbumRepository $albumRepository,
    )
    {}

    #[Route('/supprimer-album/{id}', name: 'supprimer_album')]
    public function supprimerAlbum(Request $request, int $id): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('misAjour', null);
        $maSession->set('suppression', null);
        
        $album = $this->albumRepository->find($id);
       
        $album->setSupprime(1);
        
        #je prépare ma requête à la suppression
        $this->em->persist($album);

        #j'exécute ma requête
        $this->em->flush();

        #je retourne au profil
        return $this->redirectToRoute('afficher_profil');
    }
}
