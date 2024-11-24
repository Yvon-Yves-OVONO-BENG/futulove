<?php

namespace App\Controller\Temoignage;

use App\Entity\Commentaire;
use App\Entity\Temoignage;
use App\Entity\User;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\TemoignageRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class AfficherTemoignageController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected TemoignageRepository $temoignageRepository,
        protected CommentaireRepository $commentaireRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/afficher-temoignage/{slug}', name: 'afficher_temoignage')]
    public function afficherTemoignage(Request $request, string $slug): Response
    {
        #le témoignage à afficher
        $temoignage = $this->temoignageRepository->findOneBySlug([
            'slug' => $slug
        ]);

        #photo du témoignage
        $photos = [];

        $photosTemoignages = $temoignage->getPhotoTemoignages();

        foreach ($photosTemoignages as $photoTemoignage) 
        {
            if ($photoTemoignage->isSupprime() == 0) 
            {
                $photos[] = $photoTemoignage;
            }
            
        }

        $temoignage->setNombreVues($temoignage->getNombreVues() + 1);
        
        $this->em->persist($temoignage);
        $this->em->flush();

        $autresTemoignages = [];

        #les 5 derniers témoignages
        $lesTemoignages = $this->temoignageRepository->findBy([], ['id' => 'DESC' ]);

        foreach ($lesTemoignages as $autreTemoignage) 
        {
            if ($autreTemoignage != $temoignage) 
            {
                $autresTemoignages[] = $autreTemoignage;
            }
        }
        
        #je recupère les commentaite du témoignage
        $commentaires = $temoignage->getCommentaires();

        #Nouveau commentaire
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        $commentForms = [];
        foreach ($temoignage->getCommentaires() as $comment) 
        {
            // $commentForms[$comment->getId()] = $this->cloneCommentForm($form);
            $commentForms[$comment->getId()] = $this->createForm(CommentaireType::class)->createView();
        }

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $commentaire->setAuteur($this->getUser())
                        ->setTemoignage($temoignage)
                        ->setSupprime(0)
                        ->setCommenteLeAt(new DateTime('now'))
                        ->setSlug(md5(uniqid('', true)))
            ;

            $parentId = $request->request->get('parent_id');

            if ($parentId) 
            {
                $parentComment = $this->commentaireRepository->find($parentId);
                $commentaire->setParent($parentComment);
            }

            $this->em->persist($commentaire);
            $this->em->flush();

            return $this->redirectToRoute('afficher_temoignage', ['slug' => $slug]);
        }

        /**
         * @var User
         */

        $user = $this->getUser();
        
         
        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('demandeAmitie')->getValue();

        return $this->render('temoignage/afficherTemoignage.html.twig', [
            'photos' => $photos,
            'csrf_token' => $csrfToken,
            'temoignage' => $temoignage,
            'commentaires' => $commentaires,
            'commentForms' => $commentForms,
            'formCommentaire' => $form->createView(),
            'autresTemoignages' => $autresTemoignages,
            // 'estAimeTemoignage' => function($temoignage) use ($user) { return $this->aimeTemoignageParUser($temoignage, $user);},
            // 'estAimeTemoignage' => function($temoignage) use ($user) { return $this->adoreTemoignageParUser($temoignage, $user);},
        ]);
    }

    
    public function aimeTemoignageParUser(Temoignage $temoignage, User $user):bool
    {
        return $temoignage->getAimeTemoignages()->contains($user);
    }

    public function adoreTemoignageParUser(Temoignage $temoignage, User $user):bool
    {
        return $temoignage->getAdoreTemoignages()->contains($user);
    }

}
