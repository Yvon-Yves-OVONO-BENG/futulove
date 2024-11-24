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
class MessageController extends AbstractController
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

    #[Route('/message', name: 'message_chattest')]
    public function chat(Request $request): JsonResponse
    {
         //je récupère la session
        $conversation = null;
        $session = $request->getSession();
        $destinataireId = $session->get('destinataire');
      
        if ($session->get('destinataire')) {
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
        
            $messages = $this->messageRepository->rechercheMessage($conversation);   
            //je récupère les messages non lus
            $userA = $this->userRepository->find($user);
            $messagesNonLus = $this->messageRepository->rechercheMessageNonLus($userA);
            if ( $messagesNonLus) {
                foreach ($messagesNonLus as $mess) {
                    if ($mess->getConversation() == $conversation) {
                        $mess->setEstLu(0);
                        $this->em->persist($mess);
                        $this->em->flush(); 
                    }
                }
            }

            $dataTmp =  array();
            foreach ($messages as $message) {
                $now =  new DateTime('now');
                $dateEnvoi = $message->getEnvoyeLeAt();
                $interval = $now->diff($dateEnvoi);
                $testeur = intval($interval->format("%d"));
                $jour = 0;
                if ($testeur >= 1 && $testeur < 365) {
                    $jour = 'Il y a '. $interval->format("%a") .' jour(s)';
                }
                if ($testeur > 365) {
                    $jour = 'Il y a '. $interval->format("%a") .' an(s)';
                }

                if ($testeur == 0) {
                    $jour = $interval->format("%H:%i");
                }
                

                $dataTmp[] = [
                    'contenu' => $message->getContenu(),
                    'envoyePar' => $message->getEnvoyePar()->getId(),
                    'envoyeA' => $message->getEnvoyeA()->getId(),
                    'conversation' => $message->getConversation(),
                    'envoyeLeAt' => $message->getEnvoyeLeAt(),
                    'luAt' => $message->getLuAt(),
                    'estLu' => $message->isEstLu(),
                    'photoEnvoyePar' => $user->getPhotoProfile(),
                    'photoEnvoyeA'=> $destinataire->getPhotoProfile(),
                    'duree' => $jour,
                    'image' => $message->getFichier(),
                    'id' => $message->getId()
                ];
                $jour = 0;
            }
            $json = new JsonResponse($dataTmp);
            // $resultat = $json->getContent();
            return $json;
        }   

        return $this->json([
            'code' => 200,
            'message' => 'success'
        ], 200);

        
    }
}
