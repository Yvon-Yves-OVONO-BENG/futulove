<?php

namespace App\Controller\Reinitialisation;
use DateTimeImmutable;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VerificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ValidationCodeCompteController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository, 
        protected TranslatorInterface $translator, 
        protected EntityManagerInterface $em, 
        protected VerificationRepository $verificationRepository,
        )
    {
    }

    #[Route('/validation-code-compte', name: 'validationcode_compte')]
    public function validationcodeCompte(Request $request): Response
    {
        $session = $request->getSession();
        $user = $session->get('user');
        $verification = $this->verificationRepository->findBy([
            'user' => $user,
            'estUtilise' => false,
            'code' => $request->request->get('code')
        ]); 
        $notification = false;
        if ($verification) {
            //je valide toutes les tentatives de code
            $verifications = $this->verificationRepository->findBy([
                'user' => $user,
                'estUtilise' => false,
            ]); 
            foreach ($verifications as $verification) {
                $verification->setEstUtilise(true)
                ->setValideAt(new DateTimeImmutable('now'));
                $this->em->persist($verification);
            }
            $this->em->flush();
            return $this->redirectToRoute('modifier_password');
        } else {
            $notification = true;
        }    
        return $this->render('mot_de_passe_oublie/verificationEmailMp.html.twig', [
            'notification' => $notification,
        ]);
    }
}
