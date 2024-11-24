<?php

namespace App\Controller\ChatTest;

use DateTime;
use App\Entity\Message;
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
use SebastianBergmann\CodeCoverage\Util\Percentage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class SelectionConversationController extends AbstractController
{
    public function __construct(protected UserRepository $userRepository, protected MessageRepository $messageRepository, protected ConversationRepository $conversationRepository, protected AmitieRepository $amitieRepository, protected EntityManagerInterface $em
    )
    {}

    #[Route('/conversation-selection/{id}', name: 'conversation_selectionnee')]
    public function conversation(Request $request, int $id = 0): JsonResponse
    {
        //je récupère la session
   
        if ($id) {
           
            $session = $request->getSession();
            $session->set('destinataire',  $id);
            $destinataireId = $session->get('destinataire');
           
            //je récupère l'amitie en conversation

            /**
             * @var User
             */
            $user = $this->getUser();
            //je mets l'utilisateur connecté en ligne dans le tchat s'il ne l'est pas encore
            if ($user) {
                if ($user->isEnLigne() == 1) {
                    $user->setEnLigne(0);
                    $this->em->persist($user);
                    $this->em->flush();
                }
            }
         
            //je récupère l'amitie en conversation
            $ami = $this->amitieRepository->find($destinataireId);
            
            //je cherche l'ami destinataire
            if ($ami->getDemandePar()->getId() == $user->getId()) {
                $destinataire = $ami->getDemandeA();
            }else {
                $destinataire = $ami->getDemandePar();
            }
            //j'envoie le destinataire dans la session
            $session->set('conversation',  $destinataire);
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
        
             //je vérifie si la conversation existe
            if ($conversationCreeUser) {
                $conversation = $conversationCreeUser;
                $messages = $this->messageRepository->rechercheMessage($conversation);  
            }elseif ($conversationCreeDestinataire) {
                $conversation = $conversationCreeDestinataire;
                $messages = $this->messageRepository->rechercheMessage($conversation);  
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
                    'id' => $message->getId(),
                    'destinataire' => $destinataire->getNom(),
                ];
                $jour = 0;
            }
            $json = new JsonResponse($dataTmp);
            // $resultat = $json->getContent();
            return $json;
           
        }

        
        return $this->json([
            'code' => 200,
            'status' => 'success'
        ], 200);
    }
}
