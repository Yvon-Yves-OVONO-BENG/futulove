<?php

namespace App\Controller\MessagePrive;

use App\Entity\ConstantsClass;
use App\Entity\MessagePrive;
use App\Form\MessagePriveType;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class EnvoyerMassagePriveController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
    ){}

    #[Route('/envoyer-massageprive/{idCompte}', name: 'envoyer_massage_prive')]
    public function envoyerMessagePrive(Request $request, int $idCompte): Response
    {
        ///je récupère la date courante
        $maintenant = new DateTime('now');

        ///je crée une nouvelle instance du message prive
        $messagePrive = new MessagePrive;
        /////je récupère le mebre à envoyer le message
        $membre = $this->userRepository->find($idCompte);

        ////je crée mon formulaire
        $messagePriveFormulaire = $request->request->get('messagePrive');
        
        if ($request->request->has('envoyerMessage')) 
        {
            ///Je set la date d'envoie du message et le membre
            $messagePrive
                ->setDateMessage($maintenant)
                ->setMembre($membre)
                ->setMessagePrive($messagePriveFormulaire)
                ->setLu(0)
                ;

            ////je demande à Doctrine de s'apprêter à modifier la BD
            $this->em->persist($messagePrive);

            ////je demande à doctrine d'apporter les modification à la BD
            $this->em->flush();
        }

        ///je récupère l'utilisateur connecté
        $user = $this->getUser();

        /////si c'est l'administrateur qui envoie le mesage
        if (in_array(ConstantsClass::ROLE_ADMINISTRATEUR, $user->getRoles())) 
        {
            return $this->render('massage_prive/envoyerMessagePriveAdmin.html.twig', [
                'membre' => $membre
            ]);
        } 
        else 
        {
            return $this->render('massage_prive/envoyerMessagePrive.html.twig', [
            ]);
        }
        
    }
}
