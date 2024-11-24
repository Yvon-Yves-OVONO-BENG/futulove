<?php

namespace App\Controller;

use DateTime;
use App\Entity\Message;
use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use App\Repository\ConversationRepository;
use App\Repository\FavoriRepository;
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
class EmojiController extends AbstractController
{
    public function __construct(
        protected AmitieRepository $amitieRepository,
        protected UserRepository $userRepository,
        protected ConversationRepository $conversationRepository,
        protected MessageRepository $messageRepository,
        protected EntityManagerInterface $em,
        protected Environment $environment,
        protected ChatService $chatService,
        protected FavoriRepository $favoriRepository
    )
    {}

    #[Route('/emoji-chat', name: 'chat_emoji')]
    public function chat(Request $request): Response
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
        //je met l'utilisateur en ligne lorsqu'il accède dans le tchat
        if ($user) {
            $user->setEnligne(0);
            $this->em->persist($user);
            $this->em->flush();
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

        ////je recupères les amis et les favories
        $amis = $this->amitieRepository->rechercheAmisUser($this->userRepository->find($user));
        $favoris = $this->favoriRepository->rechercheFavori($this->userRepository->find($user));
        
        $userA = $this->userRepository->find($user);
      
        $messagesNonLu = $this->messageRepository->rechercheMessageNonLus($userA);
      
        return $this->render('emoji/emoji.html.twig', [
            'amis' => $amis,
            'favoris' => $favoris,
            'messages' => $messages,
            'conversation' => $conversation,
            'nonLus' => $messagesNonLu
        ]);
    }
}
