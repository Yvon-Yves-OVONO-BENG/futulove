<?php

namespace App\Controller\Reinitialisation;

use App\Form\ModifierPasswordType;
use App\Repository\UserRepository;
use App\Repository\VerificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ModifierPasswordController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository, 
        protected EntityManagerInterface $em, 
        protected TranslatorInterface $translator,  
        protected VerificationRepository $verificationRepository
        )
    {}

    #[Route('/modifier-password', name: 'modifier_password')]
    public function modifierMonPassword(UserPasswordHasherInterface $passwordHasher, Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $session = $request->getSession();
        $user = $session->get('user');
        $user = $this->userRepository->findOneBy([
            'email' => $user->getEmail()
        ]);

        $form = $this->createForm(ModifierPasswordType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $encodedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword);

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('info',  $this->translator->trans('Mot de passe modifié avec succès !'));
            
            //je libère la session
            $request->getSession()->remove("user");
            $request->getSession()->remove("code");

            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            $session = $request->getSession();
            $session->set('error', $error);
            $session->set('last_username', $lastUsername);

            return $this->redirectToRoute('login');
          
        }

        return $this->render('mot_de_passe_oublie/nouveauMotDePasse.html.twig', [
            'user' => $user,
            'modifierPwForm' => $form->createView(),
        ]);
    }
}
