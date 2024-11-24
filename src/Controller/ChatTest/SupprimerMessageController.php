<?php

namespace App\Controller\ChatTest;

use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class SupprimerMessageController extends AbstractController
{
    public function __construct(protected MessageRepository $messageRepository, protected EntityManagerInterface $em
    )
    {}

    #[Route('/message-supprimer/{id}', name: 'supprimer_message')]
    public function conversation(int $id = 0): JsonResponse
    {
        if ($id) {
            //je récupère le message
            $message = $this->messageRepository->find($id);
            $message->setEstSupprime(0);
            $this->em->persist($message);
            $this->em->flush();
        }
        return $this->json([
            'code' => 200,
            'status' => 'success'
        ], 200);
    }
}
