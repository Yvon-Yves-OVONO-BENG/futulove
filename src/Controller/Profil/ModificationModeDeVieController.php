<?php

namespace App\Controller\Profil;

use App\Entity\LangueMembre;
use App\Form\ProfilMoDeVieType;
use App\Form\ProfilType;
use App\Repository\LangueRepository;
use App\Repository\UserRepository;
use App\Service\ProfilService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

#[IsGranted("ROLE_USER", message:"Accès refusé. Espace reservé uniquement aux abonnés")]
#[Route('/profil')]
class ModificationModeDeVieController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected ProfilService $profilService,
        protected LangueRepository $langueRepository,
    ){}

    #[Route('/modification-mode-de-vie', name: 'modification_mode_de_vie')]
    public function modificationModeDeVie(Request $request): Response
    {
        /////on recupère l'utlisateur connecté
        /**
         * @var User
         */
        $user = $this->getUser();
        $id = $user->getId();

        ////je récupère le profil de l'utilisateur connecte
        $profil = $this->userRepository->find($id);

        $langues = $this->langueRepository->findBy([
            'supprime' => 0 ], [
                'langue' => 'ASC'
            ]);

        $languesAchoisir = [];

        foreach ($langues as $langue) 
        {
            $languesAchoisir[$langue->getLangue()] = $langue->getId();
        }
        
        ///je lie mon formulaire à mon profil
        $form = $this->createForm(ProfilMoDeVieType::class, $profil, [
            'langues' => $languesAchoisir
        ]);
        $form->handleRequest($request);

        ////je soumet mon formulaire
        if ($form->isSubmitted() && $form->isValid()) 
        {
            #je récupère les id des langues

            $languesSelectionnes = $form->get('langue')->getData();

            if ($languesSelectionnes) 
            {
                #pour chaque id je récupère l'examen pour enregistrer dans la table lignConsultation
                foreach ($languesSelectionnes as $idLangue) 
                {
                    $langueMembre = new LangueMembre;

                    $langue = $this->langueRepository->find($idLangue);

                    $langueMembre->setMembre($profil)
                    ->setLangue($langue);
                    
                    $this->em->persist($langueMembre);
                }

            }

            $this->em->persist($profil);
            $this->em->flush();

            /**
             * @var User
             */
            $user = $this->getUser();
            return $this->redirectToRoute('afficher_profil');

        }

        return $this->render('profil/remplissageProfilModeDeVie.html.twig', [
            'profil' => $profil,
            'profilForm' => $form->createView(),
        ]);
    }
}
