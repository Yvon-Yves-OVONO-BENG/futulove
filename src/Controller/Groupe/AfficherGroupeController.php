<?php

namespace App\Controller\Groupe;

use DateTime;
use App\Entity\MessageGroupe;
use App\Form\MessageGroupeType;
use App\Entity\FichierMessageGroupe;
use App\Repository\AmitieRepository;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MembreGroupeRepository;
use App\Repository\MessageGroupeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/groupe')]
class AfficherGroupeController extends AbstractController
{
    public function __construct(
        protected RequestStack $request,
        protected EntityManagerInterface $em,
        protected TranslatorInterface $translator,
        protected AmitieRepository $amitieRepository,
        protected GroupeRepository $groupeRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected MembreGroupeRepository $membreGroupeRepository,
        protected MessageGroupeRepository $messageGroupeRepository,
    )
    {}

    #[Route('/afficher-groupe/{slug}', name: 'afficher_groupe')]
    public function afficherGroupe(Request $request, string $slug): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('misAjour', null);
        $maSession->set('suppression', null);
        
        $groupes = [];
        $groupe = $this->groupeRepository->findOneBySlug([
            'slug' => $slug
        ]);

        $messagesGroupe = $this->messageGroupeRepository->findBy([
            'groupe' => $groupe,
            'supprime' => 0
        ], [
            'id' => 'DESC'
        ]);

        /////liste des amis
        $amis = $this->amitieRepository->rechercheAmisUser($this->getUser());

        $tousLesGroupes = $this->groupeRepository->findBy([
            'supprime' => 0,
        ]);

        foreach ($tousLesGroupes as $unGroupe) 
        {
            if ($unGroupe->getId() != $groupe->getId() ) 
            {
                $groupes[] = $unGroupe;
            }
        }

        $lesMembresDuGroupe = [];
        $demandesAdhesions = [];

        foreach ($groupe->getMembreGroupes() as $membreGroupe) 
        {
            if ($membreGroupe->isSupprime() == 0 && $membreGroupe->isEtatDemande() == 1) 
            {
                $lesMembresDuGroupe[] = $membreGroupe;
            }
        }

        foreach ($groupe->getMembreGroupes() as $membreGroupe) 
        {
            if ($membreGroupe->isSupprime() == 0 && $membreGroupe->isDemande() == 1) 
            {
                $demandesAdhesions[] = $membreGroupe;
            }
        }
        
        #test d'appartenance dans le groupe
        $suisJeDansLeGroupe = $this->membreGroupeRepository->findOneBy([
            'groupe' => $groupe,
            'etatDemande' => 0,
            'membre' => $this->getUser()
        ]);
       
        # je crée mon CSRF pour sécuriser mes requêtes
        $csrfToken = $this->csrfTokenManager->getToken('afficherGroupe')->getValue();


        //////////////
        $messageGroupe = new MessageGroupe();
        $form = $this->createForm(MessageGroupeType::class, $messageGroupe);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // dd($form->get('fichierMessageGroupes')->getData());
            #je récupère les fichiers
            $fichiers = $form->get('fichierMessageGroupes')->getData();
            
            if ($fichiers) 
            {
                foreach ($fichiers as $fichier) 
                {
                    $fichierMessageGroupe = new FichierMessageGroupe();

                    #je génère un nom unique pour chaque image
                    $nouveauNomFichier = uniqid('', true).'.'.$fichier->guessExtension();
                    $fichier->move(
                        $this->getParameter('photoMessageGroupe'),
                        $nouveauNomFichier
                    );

                    $fichierMessageGroupe
                                    ->setMessageGroupe($messageGroupe)
                                    ->setFichierMessageGroupe($nouveauNomFichier)
                                    ->setSlug(md5(uniqid('', true)))
                                    ->setSupprime(0);

                    $this->em->persist($fichierMessageGroupe);
                    
                }
            }
            
            $messageGroupe->setGroupe($groupe) 
                        ->setCreeLeAt(new DateTime('now'))
                        ->setAuteur($this->getUser())
                        ->setSlug(md5(uniqid('', true)))
                        ->setSupprime(0);
            
            $this->em->persist($messageGroupe);
            $this->em->flush();

            $this->addFlash('info', $this->translator->trans('Message enregistré avec succès !'));
                
            $maSession->set('ajout', 1);

            #je vide le formulaire
            $messageGroupe = new MessageGroupe();
            $form = $this->createForm(MessageGroupeType::class, $messageGroupe);

        }

        #je retourne au profil
        return $this->render('groupe/afficherGroupe.html.twig', [
            'amis' => $amis,
            'groupe' => $groupe,
            'groupes' => $groupes,
            'csrf_token' => $csrfToken,
            'profil' => $this->getUser(),
            'messagesGroupe' => $messagesGroupe,
            'demandesAdhesions' => $demandesAdhesions,
            'formMessageGroupe' => $form->createView(),
            'lesMembresDuGroupe' => $lesMembresDuGroupe,
            'suisJeDansLeGroupe' => $suisJeDansLeGroupe,
        ]);
    }
}
