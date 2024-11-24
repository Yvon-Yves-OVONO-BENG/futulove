<?php

namespace App\Controller\Temoignage;

use App\Repository\PhotoTemoignageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/temoignage')]
class SupprimerPhotoTemoignageController extends AbstractController
{
    public function __construct(
        protected RequestStack $request,
        protected EntityManagerInterface $em,
        protected PhotoTemoignageRepository $photoTemoignageRepository,
    )
    {}

    #[Route('/supprimer-photo-temoignage', name: 'supprimer_photo_temoignage')]
    public function supprimerPhotoTemoignage(Request $request): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('misAjour', null);
        $maSession->set('suppression', null);
        
        $photoTemoignageId = (int)$request->request->get('photoTemoignage_id');
        
        $photoTemoignage = $this->photoTemoignageRepository->find($photoTemoignageId);
       
        $photoTemoignage->setSupprime(1);
        
        #je prépare ma requête à la suppression
        $this->em->persist($photoTemoignage);

        #j'exécute ma requête
        $this->em->flush();

        return new JsonResponse(['success' => true, 'supprime' => $photoTemoignage->isSupprime() ]);
    }
}
