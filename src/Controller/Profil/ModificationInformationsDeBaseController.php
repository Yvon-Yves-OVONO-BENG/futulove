<?php

namespace App\Controller\Profil;

use App\Form\ProfilInformationsDeBaseType;
use App\Form\ProfilType;
use App\Repository\FavoriRepository;
use App\Repository\UserRepository;
use App\Service\ProfilService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

#[IsGranted("ROLE_USER", message:"Accès refusé. Espace reservé uniquement aux abonnés")]
#[Route('/profil')]
class ModificationInformationsDeBaseController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected ProfilService $profilService,
        protected FavoriRepository $favoriRepository,
    ){}

    #[Route('/modification-informations-de-base', name: 'modification_informations_de_base')]
    public function modificationInformationsDeBase(Request $request): Response
    {
        /////on recupère l'utlisateur connecté
        /**
         * @var User
         */
        $user = $this->getUser();
        $id = $user->getId();

        ////je récupère le profil de l'utilisateur connecte
        $profil = $this->userRepository->find($id);

        ////je recuèpères mes favori
        $favoris = $this->favoriRepository->findBy([
            'moi' => $profil,
            'etatFavori' => 1,
        ]);
        
        ///je lie mon formulaire à mon profil
        $form = $this->createForm(ProfilInformationsDeBaseType::class, $profil);
        $form->handleRequest($request);

        ////je soumet mon formulaire
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $photo = $form->get('photoProfile')->getData();

            if ($photo) 
            {
                #je génère un nom unique pour chaque image
                $nouveauNomFichier = uniqid('', true).'.'.$photo->guessExtension();

                $photo->move(
                    $this->getParameter('photoProfils'),
                    $nouveauNomFichier
                );

                $profil->setPhotoProfile($nouveauNomFichier);
            }
            else
            {
                $profil->setPhotoProfile($request->request->get('photo'));
            }

            $aujourdhui = new \DateTime();
            $age = $aujourdhui->diff($form->get('dateNaissanceAt')->getData())->y;
            
            $profil->setAge($age);

            $this->em->persist($profil);
            $this->em->flush();

            /**
             * @var User
             */
            $user = $this->getUser();
            return $this->redirectToRoute('afficher_profil');

        }
        
        return $this->render('profil/remplissageProfilInformationsDeBase.html.twig', [
            'profil' => $profil,
            'favoris' => $favoris,
            'profilForm' => $form->createView(),
        ]);
    }
}
