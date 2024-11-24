<?php

namespace App\Controller\Reinitialisation;

use App\Entity\Verification;
use App\Repository\UserRepository;
use App\Repository\VerificationRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class EmailCompteController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManagerInterface,
        protected UserPasswordHasherInterface $hasher,
        protected TranslatorInterface $translator,
        protected VerificationRepository $verificationRepository,
        protected UserRepository $userRepository
    ) {
    }

    #[Route('/envoi-email', "envoi_email")]
    public function envoiEmail(Request $request, MailerInterface $mailer, TransportInterface $transport)
    {
        $email = new TemplatedEmail;
        $session = $request->getSession();
        if ($session->get('user')) {
            $user = $session->get('user');
        } else {
            $user = $this->userRepository->findOneBy([
                'email' => $request->request->get('email')
            ]);
            $session->set('user',$user);

        }
        $user = $this->userRepository->find($user->getId());
        
        //envoi du mail
        $email = new TemplatedEmail;
        $email->from(new Address('futulove@futulove.com ', "Futulove Service"))
            ->sender(new Address('futulove@futulove.com  ', "Futulove Service"))
            ->to($user->getEmail())
            ->subject("Verification de l'adresse email")
            ->htmlTemplate("emails/emailPw.html.twig", [
                'slug' => $user->getSlug()
            ])
            ->date(new DateTime);
        $notification = false;
        //j'envoie le code de vérification
        $verification = new Verification;
        $code  = rand(1000,99999);
        $session->set('code',$code);
        $verification->setCode($code)
        ->setValideAt(new DateTimeImmutable('now'))
        ->setUser($user)
        ->setEstUtilise(false)
        ;
        $this->entityManagerInterface->persist($verification);
        $this->entityManagerInterface->flush();
        try {
            //j'envoie le mail
            $transport->send($email);
            $mailer->send($email);
          
            //je retourne l'interface de validation du code
            return $this->render('mot_de_passe_oublie/verificationEmailMp.html.twig', [
                'notification' => $notification,
            ]);
        } catch (\Throwable) {
            $this->addFlash('info',  $this->translator->trans("Erreur lors de l'envoi des mails !"));
            return $this->render('mot_de_passe_oublie/verificationEmailMp.html.twig', [
                'notification' => $notification,
            ]);
        }
        return $this->redirectToRoute("envoi_email");
    }
}
