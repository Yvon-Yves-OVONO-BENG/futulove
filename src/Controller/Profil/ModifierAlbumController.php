<?php

namespace App\Controller\Profil;

use App\Entity\Album;
use App\Entity\PhotoAlbum;
use App\Form\ProfilAjoutAlbumType;
use App\Repository\AlbumRepository;
use App\Repository\TemoignageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/profil')]
class ModifierAlbumController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected TranslatorInterface $translator,
        protected AlbumRepository $albumRepository,
        protected TemoignageRepository $temoignageRepository,
    ){}

    #[Route('/modifier-album/{slug}', name: 'modifier_album')]
    public function modifierAlbum(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        /////on recupère l'utlisateur connecté
        /**
         * @var User
         */
        $profil = $this->getUser();

        ////je récupère le profil de l'utilisateur connecte
        $album = $this->albumRepository->findOneBySlug([
            'slug' => $slug
        ]);

        ///je lie mon formulaire à mon profil
        $form = $this->createForm(ProfilAjoutAlbumType::class, $album);
        $form->handleRequest($request);
        
        ////je soumet mon formulaire
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // $errors = $form->getErrors(true, false);

            // foreach ($errors as $error) 
            // {
            //     dump($error->getMessage());
            // }

            $photos = $form->get('photoAlbums')->getData();
            // dd($form->get('titreAlbum')->getData());
            foreach ($photos as $photo) 
            {
                $nouvellePhoto = new PhotoAlbum();

                #je génère un nom unique pour chaque image
                $nouveauNomFichier = uniqid('', true).'.'.$photo->guessExtension();
                $photo->move(
                    $this->getParameter('photoAlbums'),
                    $nouveauNomFichier
                );

                $nouvellePhoto->setPhotoAlbum($nouveauNomFichier) 
                ->setAlbum($album)
                ->setSupprime(0);

                $this->em->persist($nouvellePhoto);

            }

            $album->setSupprime(0)
                ->setAuteur($this->getUser())
                ->setCreeLeAt(new \DateTime())
                ->setSlug(md5(uniqid('', true)));

            $this->em->persist($album);
            $this->em->flush();

            $this->addFlash('info', $this->translator->trans('Album enregistré avec succès !'));
                
            $mySession->set('ajout', 1);

            return $this->redirectToRoute('afficher_album', ['slug' => $album->getSlug()]);
        }

        return $this->render('profil/ajouterAlbum.html.twig', [
            'slug' => $slug,
            'profil' => $profil,
            'album' => $album,
            'formAlbum' => $form->createView(),
        ]);
    }
}
