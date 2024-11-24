<?php

namespace App\Controller\Commentaire;

use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use App\Repository\TemoignageRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/commentaire')]
class AjoutCommentaireController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected CommentaireRepository $commentaireRepository,
        protected TemoignageRepository $temoignagneRepository,
    ){}

    #[Route('/ajout-commentaire/{id}/{idTemoignage}', name: 'ajout_commentaire')]
    public function ajoutCommentaire(Request $request, int $id = 0, int $idTemoignage = 0): Response
    {
        
        if($request->request->has('envoyer') && $request->request->has('commentaire'))
        {
            $commentaire = new Commentaire();

            $commentaire->setCommentaire($request->request->get('commentaire'))
                        ->setAuteur($this->getUser())
                        ->setCommenteLeAt(new DateTime('now'))
                        ->setSupprime(0)
                        ->setSlug(md5(uniqid('', true)));
                        
            if ($id != 0 && $idTemoignage) 
            {
                $commentaire->setParent($this->commentaireRepository->find($id));
            }
            
            if ($idTemoignage && $id == 0) 
            {
                $commentaire->setTemoignage($this->temoignagneRepository->find($idTemoignage));
            }

            $this->em->persist($commentaire);
            $this->em->flush();

            return $this->redirectToRoute('afficher_temoignage', 
                ['slug' => $this->temoignagneRepository->find($idTemoignage)->getSlug() 
            ]);
        }
    }
}
