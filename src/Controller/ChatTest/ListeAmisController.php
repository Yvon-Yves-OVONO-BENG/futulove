<?php

namespace App\Controller\ChatTest;

use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use App\Repository\MessageRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class ListeAmisController extends AbstractController
{
    public function __construct(
        protected AmitieRepository $amitieRepository,
        protected UserRepository $userRepository,
        protected MessageRepository $messageRepository,
    )
    {}

    #[Route('/liste-amis', name: 'liste_amis')]
    public function listeAmis(Request $request): JsonResponse
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        $session = $request->getSession();
        $destinataireId = $session->get('destinataire');
        ////je recupères les amis
        $amis = $this->amitieRepository->rechercheAmis($this->userRepository->find($user));
       
        //je récupère les messages non lus
        $userA = $this->userRepository->find($user);
      
        $messagesNonLu = $this->messageRepository->rechercheMessageNonLus($userA);
      
        
        foreach ($amis as $ami) {
            $nonLu = 0;
            //je cherche l'ami destinataire
            if ($ami->getDemandePar()->getId() == $user->getId()) {
                $destinataire = $ami->getDemandeA();
            }else {
                $destinataire = $ami->getDemandePar();
            }
            foreach ($messagesNonLu as $mes) {
                
                if ($mes->getEnvoyePar()->getId() == $destinataire->getId()) {
                    $nonLu = $nonLu + 1;
                }
            }
            $dataTmp[] = [
                'nom' => $destinataire->getNom(),
                'photo' => $destinataire->getPhotoProfile(),
                'nonLu' => $nonLu,
                'id' => $ami->getId(),
                'envoyerPar' => $destinataire->getId(),
                'enLigne' => $destinataire->isEnLigne(),
                'destinataire' => $destinataireId,
                
            ];
        }
      
        $json = new JsonResponse($dataTmp);
        // $resultat = $json->getContent();
        return $json;
    
    }
}
