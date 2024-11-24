<?php

namespace App\Controller\Groupe;

use App\Entity\MessageGroupe;
use App\Repository\MessageGroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/groupe')]
class ModifierMessageGroupeController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected MessageGroupeRepository $messageGroupeRepository,
    ){}

    #[Route('/modifier-message-groupe/{slugMessageGroupe}', name: 'modifier_message_groupe', methods: ['POST'])]
    public function modifierMessageGroupe(Request $request, MessageGroupe $messageGroupe): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $messageGroupe->setMessageGroupe($data['content']);

        $this->em->persist($messageGroupe);
        $this->em->flush();

        return new JsonResponse(['success' => true]);

    }

    #[Route('/message-groupe-edit/{id}/edit', name: 'edit_messageGroupe')]
    public function editMessageGroupe($id)
    {
        $messageGroupe = $this->messageGroupeRepository->find($id);
        if ($messageGroupe && $messageGroupe->getAuteur() == $this->getUser()) {
            return new JsonResponse(['messageGroupeContent' => $messageGroupe->getMessageGroupe()]);
        }
        
        return new JsonResponse(['error' => 'Unauthorized'], 403);
    }

    #[Route('/message-groupe-update/{id}/update', name: 'update_messageGroupe')]
    public function updateMessageGroupe(Request $request, $id)
    {
        $messageGroupe = $this->messageGroupeRepository->find($id);
        if ($messageGroupe && $messageGroupe->getAuteur() == $this->getUser()) {
            $data = json_decode($request->getContent(), true);
            $messageGroupe->setMessageGroupe($data['content']);
            $this->em->flush();
            
            return new JsonResponse(['newContent' => $messageGroupe->getMessageGroupe()]);
        }
        
        return new JsonResponse(['error' => 'Unauthorized'], 403);
    }
}
