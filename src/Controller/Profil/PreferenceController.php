<?php

namespace App\Controller\Profil;

use App\Form\ProfilType;
use App\Entity\Preference;
use App\Form\PreferenceType;
use App\Service\ProfilService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProfilInformationsPhysiquesType;
use App\Repository\AgeRepository;
use App\Repository\PreferenceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted("ROLE_USER", message:"Accès refusé. Espace reservé uniquement aux abonnés")]
#[Route('/profil')]
class PreferenceController extends AbstractController
{
    public function __construct(
        protected AgeRepository $ageRepository,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected ProfilService $profilService,
        protected PreferenceRepository $preferenceRepository
    ){}

    #[Route('/preference', name: 'preference')]
    public function preference(Request $request): Response
    {
        /////on recupère l'utlisateur connecté
        /**
         * @var User
         */
        $user = $this->getUser();
        $id = $user->getId();

        ////je récupère le profil de l'utilisateur connecte
        $profil = $this->userRepository->find($id);

        #mes préférences
        $preference = $this->preferenceRepository->findOneBy([
            'user' => $profil
        ]);

        if ($preference) 
        {
            $preference;
        } 
        else 
        {
            $preference = new Preference();
        }

        ///je lie mon formulaire à mon profil
        $form = $this->createForm(PreferenceType::class, $preference);

        $form->handleRequest($request);

        ////je soumet mon formulaire
        if ($form->isSubmitted() && $form->isValid()) 
        {

            if ($request->request->get('ageMinimum') != null) 
            {
                $ageMinimum = $this->ageRepository->find($request->request->get('ageMinimum'));
                $preference->setAgeMin($ageMinimum);
            }

            if ($request->request->get('ageLimite') != null) 
            {
                $ageLimite = $this->ageRepository->find($request->request->get('ageLimite'));
                $preference->setAgeMax($ageLimite);
            }

            $preference->setUser($this->getUser());

            $this->em->persist($preference);
            $this->em->flush();

            /**
             * @var User
             */
            $user = $this->getUser();
            return $this->redirectToRoute('afficher_profil');

        }

        ///je récupère les âges
        $ages = $this->ageRepository->findAll();

        return $this->render('profil/preference.html.twig', [
            'ages' => $ages,
            'preferenceForm' => $form->createView(),
        ]);
    }
}
