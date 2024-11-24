<?php

namespace App\Controller\Inscription;

use DateTime;
use App\Entity\User;
use App\Service\JWTService;
use App\Entity\Verification;
use App\Entity\ConstantsClass;
use App\Service\SendMailService;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use App\Repository\FormuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        protected FormuleRepository $formuleRepository, 
        protected TranslatorInterface $translator,
        protected UserRepository $userRepository,
        ){}
    
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SendMailService $mail, JWTService $jwt, UserAuthenticatorInterface $userAuthenticator, TransportInterface $transport, MailerInterface $mailer): Response
    {
        // $mySession = $request->getSession()->get('mySession', []);
        // if(!$mySession)
        // {
        //     return $this->redirectToRoute("app_logout");
        // }
        
        
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            ///je récupère la formule gratuite
            $formule = $this->formuleRepository->find(1);
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            )
            ->setRoles([ConstantsClass::ROLE_MEMBRE])
            ->setFormule($formule)
            ->setIsVerified(false)
            ->setSlug(md5(uniqid()))
            ;

            switch ($form->get('sexe')->getData()->getSexe()) 
            {
                case ConstantsClass::FEMME:
                    $user->setPhotoProfile(ConstantsClass::FEMME);
                    break;
                case ConstantsClass::HOMME:
                    $user->setPhotoProfile(ConstantsClass::HOMME);
                    break;
                
            }

            // 
            $entityManager->persist($user);
            $entityManager->flush();
            $user = $this->userRepository->findOneBy([
                'email' => $form->get('email')->getData()
            ]);
            $verification = new Verification;
            $verification->setUser($user)
            ->setEstUtilise(false);
            $entityManager->persist($verification);
            $entityManager->flush();
            $session = $request->getSession();
            $session->set('user',$user);

            return $this->redirectToRoute("verification_email");
           
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
  
}
