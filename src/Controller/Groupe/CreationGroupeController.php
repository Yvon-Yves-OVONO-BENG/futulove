<?php

namespace App\Controller\Groupe;

use App\Entity\Groupe;
use App\Entity\MembreGroupe;
use App\Entity\PhotoGroupe;
use App\Form\ProfilAjoutGroupeType;
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
#[Route('/groupe')]
class CreationGroupeController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected TranslatorInterface $translator,
        protected TemoignageRepository $temoignageRepository,
    ){}

    #[Route('/creation-groupe', name: 'creation_groupe')]
    public function ajouterGroupe(Request $request): Response
    {
        $mySession = $request->getSession();
        /////on recupère l'utlisateur connecté
        /**
         * @var User
         */
        $profil = $this->getUser();

        ////je récupère le profil de l'utilisateur connecte
        $groupe = new Groupe();

        #membre du groupe
        $membreGroupe = new MembreGroupe;

        ///je lie mon formulaire à mon profil
        $form = $this->createForm(ProfilAjoutGroupeType::class, $groupe);
        $form->handleRequest($request);
        
        ////je soumet mon formulaire
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // $errors = $form->getErrors(true, false);

            // foreach ($errors as $error) 
            // {
            //     dump($error->getMessage());
            // }

            $photo = $form->get('photo')->getData();
            
            
            #je génère un nom unique pour chaque image
            $nouveauNomFichier = uniqid('', true).'.'.$photo->guessExtension();
            $photo->move(
                $this->getParameter('photoGroupes'),
                $nouveauNomFichier
            );

            $membreGroupe->setMembre($this->getUser())
                ->setGroupe($groupe)
                ->setSupprime(0)
                ->setEtatDemande(1)
                ->setAjouteLeAt(new \DateTime());

            $groupe->setSupprime(0)
                ->setCreateur($this->getUser())
                ->setCreeLeAt(new \DateTime())
                ->setSlug(md5(uniqid('', true)))
                ->setPhoto($nouveauNomFichier);

            $this->em->persist($membreGroupe);
            $this->em->persist($groupe);
            $this->em->flush();

            $this->addFlash('info', $this->translator->trans('Groupe enregistré avec succès !'));
                
            $mySession->set('ajout', 1);

            return $this->redirectToRoute('afficher_profil');
        }

        return $this->render('groupe/creerGroupe.html.twig', [
            'slug' => null,
            'profil' => $profil,
            'formGroupe' => $form->createView(),
        ]);
    }
}
