<?php

namespace App\Controller\Photo;

use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class SupprimerPhotoController extends AbstractController
{
    public function __construct(
        protected PhotoRepository $photoRepository,
        protected EntityManagerInterface $em
    )
    {}

    #[Route('/supprimer-photo/{idPhoto}', name: 'supprimer_photo')]
    public function supprimerPhoto(int $idPhoto): Response
    {
        ///je récupère la photo à supprimer
        $photo = $this->photoRepository->find($idPhoto);

        $this->em->remove($photo);
        $this->em->flush();

        return $this->redirectToRoute('afficher_profil');
    }
}
