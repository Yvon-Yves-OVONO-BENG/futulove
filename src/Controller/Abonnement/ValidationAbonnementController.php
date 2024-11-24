<?php

namespace App\Controller\Abonnement;

use App\Entity\ConstantsClass;
use App\Repository\FormuleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class ValidationAbonnementController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected FormuleRepository $formuleRepository,
        protected EntityManagerInterface $em
    ){}

    #[Route('/validation-paiement/{idFormule}', name: 'validation_paiement')]
    public function validationPaiement($idFormule): Response
    {
        /**
         * @var User
         */
        $userConnecte = $this->getUser();
        $idUser = $userConnecte->getId();

        $user = $this->userRepository->find($idUser);

        if(!$user)
        {
            $this->addFlash('warning', 'Veuillez vous connecter !');
        }

        $formule = $this->formuleRepository->find($idFormule);

        $user->setFormule($formule);
        $this->em->persist($user);
        $this->em->flush();

        $this->addFlash('success', 'Abonnement effectué avec succès !');

        return $this->redirectToRoute('liste_membres');
    }
}
