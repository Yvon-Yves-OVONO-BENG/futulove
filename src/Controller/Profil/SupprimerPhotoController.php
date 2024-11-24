<?php

namespace App\Controller\Profil;

use App\Repository\PhotoAlbumRepository;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/profil')]
class SupprimerPhotoController extends AbstractController
{
    public function __construct(
        protected RequestStack $request,
        protected EntityManagerInterface $em,
        protected PhotoRepository $photoRepository,
        protected PhotoAlbumRepository $photoAlbumRepository,
    )
    {}

    #[Route('/supprimer-photo/{idPhoto}/{idPhotoAlbum}', name: 'supprimer_photo')]
    public function supprimerPhoto(Request $request, int $idPhoto = 0, int $idPhotoAlbum = 0): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('misAjour', null);
        $maSession->set('suppression', null);
        
        if ($idPhoto != 0) 
        {
            $photo = $this->photoRepository->find($idPhoto);

            $photo->setSupprime(1);
        
            #je prépare ma requête à la suppression
            $this->em->persist($photo);

            #j'exécute ma requête
            $this->em->flush();

            #je retourne au profil
            return $this->redirectToRoute('afficher_profil');
        } 
        elseif($idPhotoAlbum != 0)
        {
            $photo = $this->photoAlbumRepository->find($idPhotoAlbum);

            $photo->setSupprime(1);
        
            #je prépare ma requête à la suppression
            $this->em->persist($photo);

            #j'exécute ma requête
            $this->em->flush();

            #je retourne au profil
            return $this->redirectToRoute('afficher_album', ['slug' => $photo->getAlbum()->getSlug()]);
        }
        
    }
}
