<?php

namespace App\Controller\Profil;

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
class RemplissageProfilController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected ProfilService $profilService
    ){}

    #[Route('/remplissage-profil', name: 'remplissage_profil')]
    public function remplissageProfil(Request $request): Response
    {
        /////on recupère l'utlisateur connecté
        /**
         * @var User
         */
        $user = $this->getUser();
        $id = $user->getId();

        ////je récupère le profil de l'utilisateur connecte
        $profil = $this->userRepository->find($id);
        $profil->setPhotoProfile('')
            // ->setPhotoCouverture('')
        ;
        ///je lie mon formulaire à mon profil
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        ////je soumet mon formulaire
        if ($form->isSubmitted()) 
        {
            return $this->profilService->handleProfilFormData($form);
        }

        return $this->render('profil/remplissageProfil.html.twig', [
            'profilForm' => $form->createView(),
        ]);
    }
}
