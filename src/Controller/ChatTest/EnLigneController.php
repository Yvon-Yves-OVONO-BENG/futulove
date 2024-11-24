<?php

namespace App\Controller\ChatTest;

use DateTime;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class EnLigneController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em, 
        protected UserRepository $userRepository,
        protected MessageRepository $messageRepository
        )
    {}

    #[Route('/en-ligne', name: 'en_ligne')]
    public function enLigne(): JsonResponse
    {
        //cette fonction vérifie les utilisateurs en ligne et déconnecte tous ceux qui ne se sont pas déconnectés
        
        //je recupère les utilisateur en ligne
        $users = $this->userRepository->findBy([
            'enLigne' => 0
        ]);
        
        foreach ($users as $user) {
            //je récupère le dernier message de chaque utilisateur
            $messages = $this->messageRepository->rechercheDernierMessage($user);
            if ($messages) {
                foreach ($messages as $message) {
                    $now =  new DateTime('now');
                    $dateEnvoi = $message->getEnvoyeLeAt();
                    //je calcule la différence des dates
                    $interval = $now->diff($dateEnvoi);
                    //je trouve le nombre de minutes de cette différence de date
                    $minute = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
                    if($minute > 60){
                        $user->setEnLigne(1);
                        $this->em->persist($user);
                    }
                }
            }else {
                $user->setEnLigne(1);
                $this->em->persist($user);
            }
        }
        $this->em->flush();
        return $this->json([
            'code' => 200,
            'status' => 'success'
        ], 200);
    }
}
