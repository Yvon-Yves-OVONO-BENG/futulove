<?php

namespace App\Controller\ChatTest;

use DateTime;
use Twig\Environment;
use App\Entity\Message;
use App\Form\MessageType;
use App\Service\ChatService;
use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use App\Repository\ConversationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\UrlValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class InsertMessageController extends AbstractController
{
    public function __construct(
        protected AmitieRepository $amitieRepository,
        protected UserRepository $userRepository,
        protected ConversationRepository $conversationRepository,
        protected MessageRepository $messageRepository,
        protected EntityManagerInterface $em,
        protected Environment $environment,
        protected RequestStack $requestStack,
        protected ChatService $chatService,
        protected ParameterBagInterface $parameters
    )
    {}

    #[Route('/message-insert', name: 'message_insert')]
    public function chat(Request $request): Response
    {
         //je récupère la session
    
        $session = $request->getSession();
        if ($session->get('destinataire')) {
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
         
            $message =  new Message;
            $date = new DateTime('now');
            $userU = $this->userRepository->find($user);
            $message->setEnvoyeA($destinataire)
            ->setEnvoyePar($userU)
            ->setContenu($request->request->get('chat-input'))
            ->setEnvoyeLeAt($date)
            ->setConversation($conversation)
            ->setEstLu(1)
            ->setEstSupprime(1)
            ->setLuAt($date);

            if ($request->files->has('image')) {
                $myFile =  $request->files->get('image');
                $newFileName = uniqid(more_entropy: true) . ".{$myFile->guessExtension()}";
                $myFile->move($this->parameters->get('imageChat.upload_directory'), $newFileName);
                $message->setFichier($newFileName);
            }

            if ($request->files->has('fichier')) {
                $myFile =  $request->files->get('fichier');
                $newFileName = uniqid(more_entropy: true) . ".{$myFile->guessExtension()}";
                $myFile->move($this->parameters->get('fichierChat.upload_directory'), $newFileName);
                $message->setFichier($newFileName);
            }
            
            $this->em->persist($message);
            $this->em->flush();
        }
        /////********************************** */


        return $this->json([
            'code' => 200,
            'status' => 'success'
        ], 200);
    }
}
