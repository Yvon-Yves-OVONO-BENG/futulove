<?php

namespace App\Controller\Temoignage;

use DateTime;
use App\Form\TemoignageType;
use App\Entity\PhotoTemoignage;
use App\Repository\TemoignageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/temoignage')]
class ModifierTemoignageController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected TranslatorInterface $translator,
        protected TemoignageRepository $temoignageRepository,
    )
    {}
    
    #[Route('/modifier-temoignage/{slug}', name: 'modifier_temoignage')]
    public function modifiertemoignage(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();

        $temoignage = $this->temoignageRepository->findOneBySlug([
            'slug' => $slug
        ]);

        #je récupère mes témoignages
        $mesTemoignages = $this->temoignageRepository->findBy([
            'supprime' => 0,
            'createdBy' => $this->getUser(),
        ]);
        
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
                $nouveauNomFichier = uniqid().'.'.$photo->guessExtension();
                $photo->move(
                    $this->getParameter('photoTemoignages'),
                    $nouveauNomFichier
                );

                $photoTemoignage->setPhotoTemoignage($nouveauNomFichier)->setSupprime(0);
                $temoignage->addPhotoTemoignage($photoTemoignage)
                            ->setCreatedAt(new DateTime('now'))
                            ->setCreatedBy($this->getUser())
                            ->setSlug(md5(uniqid('', true)))
                            ->setSupprime(0)
                            ;
            }

            $this->em->persist($temoignage);
            $this->em->flush();

            $this->addFlash('info', $this->translator->trans('Témoignage mis à jour avec succès !'));
                
            $mySession->set('misAjour', 1);

            return $this->redirectToRoute('mes_temoignages');

        }

        return $this->render('temoignage/ajoutTemoignage.html.twig', [
            'slug' => $slug,
            'temoignage' => $temoignage,
            'mesTemoignages' => $mesTemoignages,
            'formTemoignage' => $form->createView(),
        ]);
    }
}
