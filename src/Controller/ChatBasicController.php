<?php

namespace App\Controller;

use DateTime;
use App\Entity\Message;
use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use App\Repository\ConversationRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class ChatBasicController extends AbstractController
{
    public function __construct(
        protected AmitieRepository $amitieRepository,
        protected UserRepository $userRepository,
        protected ConversationRepository $conversationRepository,
        protected MessageRepository $messageRepository,
        protected EntityManagerInterface $em,
    )
    {}

    #[Route('/chat-basic', name: 'chat_basic')]
    public function chatBasic(Request $request): Response
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

        return $this->render('chat/chatBasic.html.twig', [
            'amis' => $amis,
            'messages' => $messages,
            'destinataire' => $destinataire,
            'conversation' => $conversation

        ]);
    }
}
