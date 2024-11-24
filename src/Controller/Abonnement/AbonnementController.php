<?php

namespace App\Controller\Abonnement;

use App\Repository\FormuleRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class AbonnementController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected FormuleRepository $formuleRepository
    )
    {}

    #[Route('/abonnement/{formule}', name: 'abonnement')]
    public function abonnement($formule): Response
    {
        /**
         * @var User
         */
        $userConnecte = $this->getUser();
        $idUser = $userConnecte->getId();

        ////je récupère l'utilisateur connecté et la formule
        $user = $this->userRepository->find($idUser);
        $formule = $this->formuleRepository->findOneByFormule($formule);
        
        if (!$formule) 
        {
            return $this->redirectToRoute('nos_formules');
        }

        /////////////PROCESSUS DE PAYEMENT STRIPE
        \Stripe\Stripe::setApiKey('sk_test_51G7i0ZBBjE3mqvkVKqdkX1G4t2fYr1UE2NSJ58A5V9yX9jiKlUCGNEriN7zPM3smozvDjdWMs36DauF1ZXphAL6W00Ta07YHgq');

        $intent = \Stripe\PaymentIntent::create([
            'amount' => $formule->getPrix(),
            'currency' => 'usd',
        ]);
        
        return $this->render('abonnement/abonnement.html.twig', [
            'formule' => $formule,
            'clientSecret' => $intent->client_secret,
        ]);
    }
}
