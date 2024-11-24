<?php

namespace App\Controller\Temoignage;

use App\Repository\TemoignageRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/temoignage')]
class SupprimerTemoignageController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected TranslatorInterface $translator,
        protected TemoignageRepository $temoignageRepository,
    ){}

    #[Route('/supprimer-temoignage/{slug}', name: 'supprimer_temoignage')]
    public function supprimerTemoignage(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();

        $temoignage = $this->temoignageRepository->findOneBySlug([
            'slug' => $slug
        ]);

        $temoignage->setSupprime(1)
                    ->setSupprimeAt(new DateTime('now'))
                    ->setSupprimeBy($this->getUser());

        $this->em->persist($temoignage);
        $this->em->flush();

        $this->addFlash('info', $this->translator->trans('Témoignage supprimé avec succès !'));
                
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('mes_temoignages', ['s' => 1 ]);
    }
}
