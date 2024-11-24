<?php

namespace App\Controller\Profil;

use App\Repository\LangueMembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class SupprimerLangueMembreController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected LangueMembreRepository $langueMembreRepository
    ){}

    #[Route('/supprimer-langue-embre/{id}', name: 'supprimer_langue_membre')]
    public function supprimerLanguemembre(int $id): Response
    {
        $languemembre = $this->langueMembreRepository->find($id);

        $this->em->remove($languemembre);
        $this->em->flush();

        return $this->redirectToRoute('modification_mode_de_vie');
    }
}
