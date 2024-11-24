<?php

namespace App\Controller\Groupe;

use App\Repository\UserRepository;
use App\Form\ProfilAjoutGroupeType;
use App\Repository\GroupeRepository;
use App\Repository\TemoignageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/profil')]
class ModifierGroupeController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected TranslatorInterface $translator,
        protected GroupeRepository $groupeRepository,
        protected TemoignageRepository $temoignageRepository,
    ){}

    #[Route('/modifier-groupe/{slug}', name: 'modifier_groupe')]
    public function ajouterGroupe(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        /////on recupère l'utlisateur connecté
        /**
         * @var User
         */
        $profil = $this->getUser();

        ////je récupère le profil de l'utilisateur connecte
        $groupe = $this->groupeRepository->findOneBySlug([
            'slug' => $slug
        ]);
       
        # je vérifie si la photo existe pour ne pas avoir d'erreur au niveau le champ photo qui est de type
        # dtring mais attent un objet de type file
        // if ($groupe->getPhoto()) 
        // {
        //     $groupe->setPhoto(
        //         new File($this->getParameter('photoGroupes').'/'.$groupe->getPhoto())
        //     );
        // }
       
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
            
            if ($photo) 
            {
                #je génère un nom unique pour chaque image
                $nouveauNomFichier = uniqid('', true).'.'.$photo->guessExtension();
                $photo->move(
                    $this->getParameter('photoGroupes'),
                    $nouveauNomFichier
                );
                $groupe->setPhoto($nouveauNomFichier);
            }
            
            $groupe->setSupprime(0)
                ->setCreateur($this->getUser())
                ->setCreeLeAt(new \DateTime())
                ->setSlug(md5(uniqid('', true)));
                
            $this->em->persist($groupe);
            $this->em->flush();

            $this->addFlash('info', $this->translator->trans('Groupe enregistré avec succès !'));
                
            $mySession->set('ajout', 1);

            return $this->redirectToRoute('afficher_profil');
        }

        return $this->render('groupe/creerGroupe.html.twig', [
            'slug' => $slug,
            'profil' => $profil,
            'groupe' => $groupe,
            'formGroupe' => $form->createView(),
        ]);
    }
}
