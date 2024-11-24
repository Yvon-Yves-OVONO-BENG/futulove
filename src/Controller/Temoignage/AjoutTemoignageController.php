<?php

namespace App\Controller\Temoignage;

use App\Entity\PhotoTemoignage;
use App\Entity\Temoignage;
use App\Form\TemoignageType;
use App\Repository\AmitieRepository;
use App\Repository\FavoriRepository;
use App\Repository\GroupeRepository;
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
#[Route('/temoignage')]
class AjoutTemoignageController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected TranslatorInterface $translator,
        protected FavoriRepository $favoriRepository,
        protected GroupeRepository $groupeRepository,
        protected AmitieRepository $amitieRepository,
        protected TemoignageRepository $temoignageRepository,
    )
    {}

    #[Route('/ajout-temoignage', name: 'ajout_temoignage')]
    public function ajoutTemoignage(Request $request): Response
    {
        $mySession = $request->getSession();

        #je récupère mes témoignages
        $mesTemoignages = $this->temoignageRepository->findBy([
            'supprime' => 0,
            'createdBy' => $this->getUser(),
        ]);

        #je récupère les demandes d'amitié
        $demandesAmitie = $this->amitieRepository->findBy([
            'demandeA' => $this->getUser(),
            'statut' => 1,
        ]);

        #je récupère mes favoris
        $mesFavoris = $this->favoriRepository->findBy([
            'moi' => $this->getUser()
        ]);

        #je récupère mes favoris
        $jeSuisLeurFavori = $this->favoriRepository->findBy([
            'favori' => $this->getUser()
        ]);

        #je récupère mes groupes
        $mesGroupes = $this->groupeRepository->findBy([
            'createur' => $this->getUser()
        ]);

        #je récupère les amis bloqués
        $amisBloques = $this->amitieRepository->rechercheAmisBloques($this->getUser(), );
        
        $temoignage = new Temoignage();
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // dd($form->get('photoTemoignages')->getData());
            #je récupère les fichiers
            $photos = $form->get('photoTemoignages')->getData();
            
            foreach ($photos as $photo) 
            {
                $photoTemoignage = new PhotoTemoignage();

                #je génère un nom unique pour chaque image
                $nouveauNomFichier = uniqid('', true).'.'.$photo->guessExtension();
                $photo->move(
                    $this->getParameter('photoTemoignages'),
                    $nouveauNomFichier
                );

                $photoTemoignage->setPhotoTemoignage($nouveauNomFichier)
                                ->setSupprime(0);

                $temoignage->addPhotoTemoignage($photoTemoignage)
                            ->setCreatedAt(new DateTime('now'))
                            ->setCreatedBy($this->getUser())
                            ->setSlug(md5(uniqid('', true)))
                            ->setNombreVues(0)
                            ->setSupprime(0)
                            ;
            }

            $this->em->persist($temoignage);
            $this->em->flush();

            $this->addFlash('info', $this->translator->trans('Témoignage enregistré avec succès !'));
                
            $mySession->set('ajout', 1);

            #je vide le formulaire
            $temoignage = new Temoignage();
            $form = $this->createForm(TemoignageType::class, $temoignage);

        }

        return $this->render('temoignage/ajoutTemoignage.html.twig', [
            'slug' => "",
            'mesGroupes' => $mesGroupes,
            'mesFavoris' => $mesFavoris,
            'amisBloques' => $amisBloques,
            'jeSuisLeurFavori' => $jeSuisLeurFavori,
            'demandesAmitie' => $demandesAmitie,
            'mesTemoignages' => $mesTemoignages,
            'formTemoignage' => $form->createView(),
        ]);
    }
}
