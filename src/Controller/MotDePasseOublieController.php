<?php

namespace App\Controller;

use App\Service\SendMailService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MotDePasseOublieController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected EntityManagerInterface $em
    ){}

    #[Route('/mot-de-passe-oublie', name: 'mot_de_passe_oublie')]
    public function motDePasseOublie(Request $request, UserPasswordHasherInterface $userPasswordHasher, SendMailService $mail,): Response
    {
        if ($request->request->has('envoyer')) 
        {
            ///je récupère l'email du membre qui a perdu son pwd
            $email = $request->request->get('email');
            
            ////je recupère l'utilisateur
            $user = $this->userRepository->findOneByEmail($email);
            
            /////je fabrique le nouveau mot de passe
            $characts    = 'abcdefghijklmnopqrstuvwxyz';
            $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';	
            $characts   .= '1234567890'; 
            $nouveauMotDePasse      = ''; 
    
            for($i=0;$i < 6;$i++) 
            { 
                $nouveauMotDePasse .= substr($characts,rand()%(strlen($characts)),1); 
            }

            
            $hash = $userPasswordHasher->hashPassword($user, $nouveauMotDePasse);

            $user->setPassword($hash);

            $this->em->persist($user);
            $this->em->flush();

            // // On envoie un mail
            $mail->send(
                'no-reply@monamesoeur.com',
                $user->getEmail(),
                'Nouveau mot de passe sur le site MON ÂME-SOEUR',
                'mot_de_passe_oublie',
                compact('user', 'nouveauMotDePasse')
            );
            $this->addFlash('warning', "Un mail vous a été envoyé. Vérifiez vos mails pour avoir accès au nouveau mot de passe");

            return $this->redirectToRoute('login');

        }

        return $this->render('mot_de_passe_oublie/motDePasseOublie.html.twig', [
            
        ]);
    }
}
