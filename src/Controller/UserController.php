<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Repository\SchoolRepository;
use App\Repository\UserRepository;
use App\Repository\TeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */

/**
 * @Route("/super/admin")
 */
class UserController extends AbstractController
{
    public function __construct(protected UserRepository $userRepository, protected EntityManagerInterface $em, protected UserPasswordHasherInterface $encoder, protected TranslatorInterface $translator)
    {
    }


    /**
     * @Route("/displayUser", name="user_displayUser")
     */
    public function displayUser(): Response
    {
        return $this->render('user/displayUser.html.twig', [

        ]);
    }

    
}
