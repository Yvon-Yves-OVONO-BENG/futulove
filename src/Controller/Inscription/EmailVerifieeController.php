<?php

namespace App\Controller\Inscription;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EmailVerifieeController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserPasswordHasherInterface $hasher,
        protected UserRepository $userRepository

    ) {
    }

    #[Route('/email-verifee/{slug}', name: 'email_verifiee')]
    public function emailVerifiee(Request $request, string $slug)
    {
        
        $user = $this->userRepository->findOneBy([
            'slug' => $slug
        ]);
        if ($slug) {
            $user->setIsVerified(true);
            $this->em->persist($user);
            $this->em->flush();
            //je libère la session
            $request->getSession()->remove("user");
            return $this->render("emails/verificationEmailSuccess.html.twig", [
                "user" => $user,
            ]);
        } elseif ($request->request->get("code")) {
            $error = "Echec de vérification";
            return $this->redirectToRoute("verification_email");
        }
    }
}
