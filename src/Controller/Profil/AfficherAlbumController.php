<?php

namespace App\Controller\Profil;

use App\Repository\AlbumRepository;
use App\Repository\FavoriRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/profil')]
class AfficherAlbumController extends AbstractController
{
    public function __construct(
        protected RequestStack $request,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected AlbumRepository $albumRepository,
        protected FavoriRepository $favoriRepository,
    ){}

    #[Route('/afficher-album/{slug}', name: 'afficher_album')]
    public function afficherAlbum(Request $request, string $slug): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('misAjour', null);
        $maSession->set('suppression', null);

        $jeSuisLeurFavori = null;

        /**
         * @var User
         */
        $user =  $this->getUser();
        $idUser = $user->getId();
        $profil =  $this->userRepository->find($idUser);

        # je suis leur favori
        $jeSuisLeurFavori = $this->favoriRepository->findBy([
            'favori' => $profil,
            'etatFavori' => 1,
        ]);
        
        $album = $this->albumRepository->findOneBySlug([
            'slug' => $slug
        ]);

        ////je recuèpères mes favori
        $favoris = $this->favoriRepository->findBy([
            'moi' => $user,
            'etatFavori' => 1,
        ]);

        #je retourne au profil
        return $this->render('profil/afficherAlbum.html.twig', [
            'album' => $album,
            'favoris' => $favoris,
            'profil' => $this->getUser(),
            'jeSuisLeurFavori' => $jeSuisLeurFavori,
        ]);
    }
}
