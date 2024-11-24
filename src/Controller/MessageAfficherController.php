<?php

namespace App\Controller;

use DateTime;
use App\Entity\Message;
use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use App\Repository\ConversationRepository;
use App\Repository\MessageRepository;
use App\Service\ChatService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Twig\Environment;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class MessageAfficherController extends AbstractController
{
    public function __construct(
        protected AmitieRepository $amitieRepository,
        protected UserRepository $userRepository,
        protected ConversationRepository $conversationRepository,
        protected MessageRepository $messageRepository,
        protected EntityManagerInterface $em,
        protected Environment $environment,
        protected ChatService $chatService
    )
    {}

    #[Route('/message-afficher', name: 'message_afficher')]
    public function chat(Request $request): Response
    {
         //je récupère la session
      
        $session = $request->getSession();
     
        if ($request->request->get('destinataire')) {
            $session->set('destinataire',  $request->request->get('destinataire'));
        }
        $destinataireId = $session->get('destinataire');

        /**
         * @var User
         */
        $user = $this->getUser();

        //je récupère l'amitie en conversation
        $ami = $this->amitieRepository->find($destinataireId);
        
        //je cherche l'ami destinataire
        if ($ami->getDemandePar()->getId() == $user->getId()) {
            $destinataire = $ami->getDemandeA();
        }else {
            $destinataire = $ami->getDemandePar();
        }

        //je cherche la conversation
        $conversationCreeUser = $this->conversationRepository->findOneBy([
            'creePar' => $user,
            'avec' => $destinataire
        ]);
        $conversationCreeDestinataire = $this->conversationRepository->findOneBy([
            'creePar' => $destinataire,
            'avec' => $user
        ]);
        if ($conversationCreeUser) {
            $conversation = $conversationCreeUser;
        }else {
            $conversation = $conversationCreeDestinataire;
        }

        $messages = $this->messageRepository->findBy([
            'conversation'=> $conversation
        ]);

     
        ////je recupères les amis
        $amis = $this->amitieRepository->rechercheAmis($this->userRepository->find($user));

        // return $this->json([
        //     'code' => 200,
        //     'message' => 'Succès ! '
        // ], 200);

          return $this->render('chat/chat.html.twig', [
            'amis' => $amis,
            'messages' => $messages,
            'destinataire' => $destinataire,
            'conversation' => $conversation

        ]);

    }
}
