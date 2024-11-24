<?php

namespace App\Controller;

use DateTime;
use Twig\Environment;
use App\Entity\Conversation;
use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ConversationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class DestinataireController extends AbstractController
{
    public function __construct(
        protected AmitieRepository $amitieRepository,
        protected MessageRepository $messageRepository,
        protected ConversationRepository $conversationRepository,
        protected UserRepository $userRepository,
        protected EntityManagerInterface $em,
        private Environment $environment,
    )
    {}

    #[Route('/chat-destinataire/{id}', name: 'chat_destinataire')]
    public function destinataireChat(Request $request, int $id): Response
    {
          /**
         * @var User
         */
        $user = $this->getUser();

        //je récupère l'amitie en conversation
        $ami = $this->amitieRepository->find($id);

        //je cherche l'ami destinataire
        if ($ami->getDemandePar()->getId() == $user->getId()) {
            $destinataire = $ami->getDemandeA();
        }else {
            $destinataire = $ami->getDemandePar();
        }


        //je récupère la session
        $session = $request->getSession();
        $session->set('destinataire', $destinataire);
   
        //je cherche l'utilisateur ayant créé la conversation
        $conversationCreeUser = $this->conversationRepository->findOneBy([
            'creePar' => $user,
            'avec' => $destinataire
        ]);

        $conversationCreeDestinataire = $this->conversationRepository->findOneBy([
            'creePar' => $destinataire,
            'avec' => $user
        ]);

        $conversation = null;
        //je vérifie si la conversation existe
        if ($conversationCreeUser) {
            
            $messages = $this->messageRepository->findBy([
                'conversation' => $conversationCreeUser->getId()
            ]);
            $conversation = $conversationCreeUser;
        }elseif ($conversationCreeDestinataire) {
            
            $messages = $this->messageRepository->findBy([
                'conversation' => $conversationCreeDestinataire->getId()
            ]);
            $conversation = $conversationCreeDestinataire;
        }else {
            //si la conversation n'existe pas je la crée
            $messages = null;
            $date = new DateTime('now');
            $user = $this->userRepository->find($user);
            $conversation = new Conversation;
            $conversation->setCreePar($user)
            ->setAvec($destinataire)
            ->setCreeLeAt($date)
            ->setTitre('Conversation '.$user->getNom().'-'.$destinataire->getNom())
            ;
            $this->em->persist($conversation);
            $this->em->flush();

        }
        
        ////je recupères les amis
        $amis = $this->amitieRepository->rechercheAmis($this->userRepository->find($user));

       
        // return new JsonResponse([
        //     'html' => $this->environment->render('chat/chat.html.twig', [
        //     'messages' => $messages,
        //     'amis' => $amis,
        //     'destinataire' => $destinataire,
        //     'conversation' => $conversation
        //     ])
        // ], 200);







        // $json = array(
        // );
        // $json = array(
        //     'messages' => $messages,
        //     'amis' => $amis,
        //     'destinataire' => $destinataire,
        //     'conversation' => $conversation
        // );

        // $json['view1'] = $this->renderView('chat/chat.html.twig', [
        //     'messages' => $messages,
        //     'amis' => $amis,
        //     'destinataire' => $destinataire,
        //     'conversation' => $conversation
        // ]);

        // $response = new Response(json_encode($json));

        // $response->headers->set('Content-Type', 'application/json');

        // return $response;
        
        return $this->render('chat/chat.html.twig', [
            'messages' => $messages,
            'amis' => $amis,
            'destinataire' => $destinataire,
            'conversation' => $conversation
        ]);
    }
}
