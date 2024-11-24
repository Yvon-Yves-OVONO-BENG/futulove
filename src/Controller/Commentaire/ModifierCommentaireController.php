<?php

namespace App\Controller\Commentaire;

use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/commentaire')]
class ModifierCommentaireController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected CommentaireRepository $commentaireRepository,
    ){}

    #[Route('/modifier-commentaire/{slugCommentaire}', name: 'modifier_commentaire', methods: ['POST'])]
    public function modifierCommentaire(Request $request, Commentaire $commentaire): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $commentaire->setCommentaire($data['content']);

        $this->em->persist($commentaire);
        $this->em->flush();

        return new JsonResponse(['success' => true]);

    }

    #[Route('/commentaire-edit/{id}/edit', name: 'edit_commentaire')]
    public function editComment($id)
    {
        $comment = $this->commentaireRepository->find($id);
        if ($comment && $comment->getAuteur() == $this->getUser()) {
            return new JsonResponse(['commentContent' => $comment->getCommentaire()]);
        }
        
        return new JsonResponse(['error' => 'Unauthorized'], 403);
    }

    #[Route('/commentaire-update/{id}/update', name: 'update_commentaire')]
    public function updateComment(Request $request, $id)
    {
        $comment = $this->commentaireRepository->find($id);
        if ($comment && $comment->getAuteur() == $this->getUser()) {
            $data = json_decode($request->getContent(), true);
            $comment->setCommentaire($data['content']);
            $this->em->flush();
            
            return new JsonResponse(['newContent' => $comment->getCommentaire()]);
        }
        
        return new JsonResponse(['error' => 'Unauthorized'], 403);
    }
}
