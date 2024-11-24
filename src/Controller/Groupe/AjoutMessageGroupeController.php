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
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/groupe')]
class AjoutMessageGroupeController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected AmitieRepository $amitieRepository,
        protected MembreGroupeRepository $membreGroupeRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected TranslatorInterface $translator,
        protected GroupeRepository $groupeRepository,
        protected MessageGroupeRepository $messageGroupeRepository,
    )
    {}

    #[Route('/ajout-message-groupe/{slugMessage}/{slugGroupe}', name: 'ajout_message_groupe')]
    public function ajoutMessageGroupe(Request $request, string $slugMessage, string $slugGroupe): Response
    {
        $mySession = $request->getSession();
        
        $groupe = $this->groupeRepository->findOneBy(['slug' => $slugGroupe ]);
        $parentMessage = $this->messageGroupeRepository->findOneBy(['slug' => $slugMessage ]);

        $messageGroupe = new MessageGroupe();
        $form = $this->createForm(MessageGroupeType::class, $messageGroupe);
        $form->handleRequest($request);
        
        if ($request->request->has('envoyer')) 
        { 
            $messageGroupe->setCreeLeAt(new DateTime('now'))
                            ->setAuteur($this->getUser())
                            ->setSlug(md5(uniqid('', true)))
                            ->setParent($parentMessage)
                            ->setSupprime(0)
                            ->setMessageGroupe($request->request->get('commentaire'));

            $this->em->persist($messageGroupe);
            $this->em->flush();

            $this->addFlash('info', $this->translator->trans('Message enregistré avec succès !'));
                
            $mySession->set('ajout', 1);

            return $this->redirectToRoute('afficher_groupe', ['slug' => $slugGroupe]);

        }

        $groupes = [];
        $groupe = $this->groupeRepository->findOneBySlug([
            'slug' => $groupe->getSlug()
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
            if ($membreGroupe->isSupprime() == 0 && $membreGroupe->isEtatDemande() == 0) 
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

        return $this->render('groupe/afficherGroupe.html.twig', [
            'slug' => "",
            'amis' => $amis,
            'groupe' => $groupe,
            'groupes' => $groupes,
            'csrf_token' => $csrfToken,
            'profil' => $this->getUser(),
            'demandesAdhesions' => $demandesAdhesions,
            'formMessageGroupe' => $form->createView(),
            'lesMembresDuGroupe' => $lesMembresDuGroupe,
            'suisJeDansLeGroupe' => $suisJeDansLeGroupe,
        ]);
    }
}
