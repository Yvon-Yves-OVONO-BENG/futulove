<?php

namespace App\Controller\Inscription;
use DateTimeImmutable;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VerificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ValidationCodeController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository, 
        protected TranslatorInterface $translator, 
        protected EntityManagerInterface $em, 
        protected VerificationRepository $verificationRepository,
        )
    {
    }

    #[Route('/validation-code', name: 'validation_code')]
    public function validationCode(Request $request): Response
    {
        $session = $request->getSession();
        $user = $session->get('user');
        $verification = $this->verificationRepository->findOneBy([
            'user' => $user,
            'estUtilise' => false,
            'code' => $request->request->get('code')
        ]); 
        $notification = false;
        if ($verification) {
            //je valide l'utilisation du code
            $verification->setEstUtilise(true)
            ->setValideAt(new DateTimeImmutable('now'));
            $this->em->persist($verification);
            //je valide le compte de l'utilisateur
            $user = $this->userRepository->find($user->getId());
            $user->setIsVerified(true);
            $this->em->persist($user);
          
            $this->em->flush();
            //je libère la session
            $request->getSession()->remove("user");
            $request->getSession()->remove("code");
            return $this->render("emails/verificationEmailSuccess.html.twig", [
                "user" => $user,
            ]);
        } else {
            $notification = true;
        }    
        return $this->render('emails/verificationEmail.html.twig', [
            'notification' => $notification,
        ]);
    }
}
