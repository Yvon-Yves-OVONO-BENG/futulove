<?php

namespace App\Controller\Inscription;

use App\Entity\Verification;
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

class VerificationEmailController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManagerInterface,
        protected UserPasswordHasherInterface $hasher,
        protected TranslatorInterface $translator,
        protected VerificationRepository $verificationRepository
    ) {
    }

    #[Route('/verification-email', "verification_email")]
    public function verificationEmail(Request $request, MailerInterface $mailer, TransportInterface $transport)
    {
        $email = new TemplatedEmail;
        $session = $request->getSession();
        $user = $session->get('user');
       
        //envoi du mail
        $email = new TemplatedEmail;
        $email->from(new Address('futulove@futulove.com ', "Futulove Service"))
            ->sender(new Address('futulove@futulove.com  ', "Futulove Service"))
            ->to($user->getEmail())
            ->subject("Verification de l'adresse email")
            ->htmlTemplate("emails/email.html.twig", [
                'slug' => $user->getSlug()
            ])
            ->date(new DateTime);
        $notification = false;
        //j'envoie le code de vérification
        $verification = $this->verificationRepository->findOneBy([
            'user'=> $user
        ]);
        $code  = rand(1000,99999);
        $session->set('code',$code);
        $verification->setCode($code)
        ->setValideAt(new DateTimeImmutable('now'))
        ;
        $this->entityManagerInterface->persist($verification);
        $this->entityManagerInterface->flush();
        try {
            //j'envoie le mail
            $transport->send($email);
            $mailer->send($email);
          
            //je retourne l'interface de validation du code
            return $this->render('emails/verificationEmail.html.twig', [
                'notification' => $notification,
            ]);
        } catch (\Throwable) {
            $this->addFlash('info',  $this->translator->trans("Erreur lors de l'envoi des mails !"));
            return $this->render('emails/verificationEmail.html.twig', [
                'notification' => $notification,
            ]);
        }
        return $this->redirectToRoute("verification_email");
    }
}
