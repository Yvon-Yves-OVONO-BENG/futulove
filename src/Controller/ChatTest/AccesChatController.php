<?php

namespace App\Controller\ChatTest;

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
class AccesChatController extends AbstractController
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

    #[Route('/acces-chat', name: 'chat_acces')]
    public function accesChat(Request $request): Response
    {
         //je récupère la session
         $destinataire = null;
         if ($request->request->has('envoyer')) {
             $session = $request->getSession();
             $destinataireId = $session->get('destinataire');
             $destinataire = $this->userRepository->find($destinataireId);
         }
      
        /**
         * @var User
         */
        $user = $this->getUser();
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

        $userA = $this->userRepository->find($user);
      
        $messagesNonLu = $this->messageRepository->rechercheMessageNonLus($userA);
      
        $nonLu = 0;
        foreach ($amis as $ami) {
          
            foreach ($messagesNonLu as $mes) {
                
                if ($mes->getEnvoyePar()->getId() == $destinataire->getId()) {
                    $nonLu = $nonLu + 1;
                }
            }
           
        }

        return $this->render('chatTest/accesChat.html.twig', [
            'amis' => $amis,
            'messages' => $messages,
            'destinataire' => $destinataire,
            'conversation' => $conversation,
            'nonLus' => $messagesNonLu

        ]);

        // return $this->json([
        //     "amis" => $amis
        // ], 200,);
    }
}
