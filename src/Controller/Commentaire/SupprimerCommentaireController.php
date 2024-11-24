<?php

namespace App\Controller\Commentaire;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/commentaire')]
class SupprimerCommentaireController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected CommentaireRepository $commentaireRepository,
    )
    {}

    #[Route('/supprimer-commentaire/{slugCommentaire}/{slugTemoignage}', name: 'supprimer_commentaire')]
    public function supprimerCommentaire(string $slugCommentaire, string $slugTemoignage): Response
    {
        #je récupère le commentaire à supprimer
        $commentaire = $this->commentaireRepository->findOneByslug([
            'slug' => $slugCommentaire
        ]);
        
        $commentaire->setSupprime(1);

        $this->em->persist($commentaire);
        $this->em->flush();

        return $this->redirectToRoute('afficher_temoignage', ['slug' => $slugTemoignage ]);
    }
}
