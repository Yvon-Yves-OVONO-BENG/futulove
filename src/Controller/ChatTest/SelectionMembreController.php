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
class SelectionMembreController extends AbstractController
{
    public function __construct(protected UserRepository $userRepository, protected MessageRepository $messageRepository, protected ConversationRepository $conversationRepository, protected AmitieRepository $amitieRepository, protected EntityManagerInterface $em
    )
    {}

    #[Route('/selection-membre', name: 'membre_selectionne')]
    public function conversation(Request $request): JsonResponse
    {
        
         //je récupère la session
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
             $dataTmp =  array();
             $dataTmp[] = [
                 'nom' => $destinataire->getNom(),
                 'photo' => $destinataire->getPhotoProfile(),
                 'enligne' => $destinataire->isEnLigne(),
             ];
               
             $json = new JsonResponse($dataTmp);
             // $resultat = $json->getContent();
             return $json;
         }
         return $this->json([
            'code' => 200,
            'status' => 'Aucun membre'
        ], 200);
    }
}
