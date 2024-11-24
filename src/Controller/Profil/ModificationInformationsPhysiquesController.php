<?php

namespace App\Controller\Profil;

use App\Form\ProfilInformationsPhysiquesType;
use App\Form\ProfilType;
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
class ModificationInformationsPhysiquesController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected ProfilService $profilService
    ){}

    #[Route('/modification-informations-physiques', name: 'modification_informations_physiques')]
    public function modificationInformationsPhysiques(Request $request): Response
    {
        /////on recupère l'utlisateur connecté
        /**
         * @var User
         */
        $user = $this->getUser();
        $id = $user->getId();

        ////je récupère le profil de l'utilisateur connecte
        $profil = $this->userRepository->find($id);
        
        ///je lie mon formulaire à mon profil
        $form = $this->createForm(ProfilInformationsPhysiquesType::class, $profil);
        $form->handleRequest($request);

        ////je soumet mon formulaire
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $this->em->persist($profil);
            $this->em->flush();

            /**
             * @var User
             */
            $user = $this->getUser();
            return $this->redirectToRoute('afficher_profil');

        }

        return $this->render('profil/remplissageProfilInformationsPhysiques.html.twig', [
            'profilForm' => $form->createView(),
        ]);
    }
}
