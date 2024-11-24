<?php

namespace App\Controller\Profil;

use App\Entity\Photo;
use App\Form\ProfilAjoutPhotoType;
use App\Form\ProfilType;
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
class AjouterPhotoController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected TranslatorInterface $translator,
        protected TemoignageRepository $temoignageRepository,
    ){}

    #[Route('/ajouter-photo', name: 'ajouter_photo')]
    public function ajouterPhoto(Request $request): Response
    {
        $mySession = $request->getSession();
        /////on recupère l'utlisateur connecté
        /**
         * @var User
         */
        $user = $this->getUser();
        $id = $user->getId();

        ////je récupère le profil de l'utilisateur connecte
        $profil = $this->userRepository->find($id);

        $mesTemoignages = $this->temoignageRepository->findBy([
            'supprime' => 0,
            'createdBy' => $this->getUser(),
        ]);

        ///je lie mon formulaire à mon profil
        $form = $this->createForm(ProfilAjoutPhotoType::class, $profil);
        $form->handleRequest($request);

        ////je soumet mon formulaire
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $photos = $form->get('photos')->getData();
            
            foreach ($photos as $photo) 
            {
                $nouvellePhoto = new Photo();

                #je génère un nom unique pour chaque image
                $nouveauNomFichier = uniqid('', true).'.'.$photo->guessExtension();
                $photo->move(
                    $this->getParameter('photoUsers'),
                    $nouveauNomFichier
                );

                $nouvellePhoto->setNomPhoto($nouveauNomFichier) 
                ->setUser($profil)
                ->setSupprime(0);

                $this->em->persist($nouvellePhoto);

            }

            $this->em->flush();

            $this->addFlash('info', $this->translator->trans('Phto(s) enregistrée(s) avec succès !'));
                
            $mySession->set('ajout', 1);

            return $this->redirectToRoute('afficher_profil');
        }

        return $this->render('profil/ajouterPhoto.html.twig', [
            'profil' => $profil,
            'mesTemoignages' => $mesTemoignages,
            'formPhoto' => $form->createView(),
        ]);
    }
}
