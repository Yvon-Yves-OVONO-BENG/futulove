<?php

namespace App\Controller\Profil;

use App\Entity\ConstantsClass;
use App\Entity\Preference;
use App\Repository\AgeRepository;
use App\Repository\SexeRepository;
use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use App\Repository\FavoriRepository;
use App\Repository\GroupeRepository;
use App\Repository\MembreGroupeRepository;
use App\Repository\MessagePriveRepository;
use App\Repository\PreferenceRepository;
use App\Repository\SignalementRepository;
use App\Repository\TemoignageRepository;
use App\Service\MatchingService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/profil')]
class AfficherProfilController extends AbstractController
{
    public function __construct(
        protected AgeRepository $ageRepository,
        protected SexeRepository $sexeRepository,
        protected UserRepository $userRepository,
        protected MatchingService $matchingService,
        protected AmitieRepository $amitieRepository,
        protected FavoriRepository $favoriRepository,
        protected GroupeRepository $groupeRepository,
        protected PreferenceRepository $preferenceRepository,
        protected TemoignageRepository $temoignageRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected SignalementRepository $signalementRepository,
        protected MessagePriveRepository $messagePriveRepository,
        protected MembreGroupeRepository $membreGroupeRepository,
        ){}
    
    #[Route('/afficher-profil/{slug}', name: 'afficher_profil')]
    public function afficherProfil(string $slug = ""): Response
    {
        $amis = null;
        $user = null;
        $favori = null;
        $favoris = null;
        $signalement = null;
        $invitations = null;
        $amitieBloque = null;
        $amisBloques = null;
        $amisDemandes = null;
        $messagePrives = null;
        $jeSuisLeurFavori = null;
        $demandesAmitie  = null;
        $mesFavoris  = null;
        $mesGroupes  = null;

        $mesTemoignages = $this->temoignageRepository->findBy([
            'supprime' => 0,
            'createdBy' => $this->getUser(),
        ]);
        
        

        if ($slug != null) 
        {
            /**
             * @var User
             */
            $utilisateurDemandeur = $this->getUser();
            
            $profil = $this->userRepository->findOneBySlug([
                'slug' => $slug
            ]);
            
             #mes préférences
            $preference = $this->preferenceRepository->findOneBy([
                'user' => $profil
            ]);
            
            if ($preference) 
            {
                $preference;
            } 
            else 
            {
                $preference = new Preference();
            }
            
            #invitation des les groupes
            $invitationsGroupes = [];

            $amis = $this->amitieRepository->rechercheAmisUser($profil);
            ////je vérifie si on peut afficher le profil d'un membre selon l'abonnement
            ////je récupère la formule de l'utilisateur connecté
            $maFormule = $utilisateurDemandeur->getFormule()->getFormule();

            ///je récupère la formule du membre dont on veut afficher le profil
            $saFormule = $profil->getFormule()->getFormule();

            ////je teste
            if ($maFormule === $saFormule) 
            {
                /////je récupère l'amitié
                $amitie = $this->amitieRepository->findOneBy([
                    'demandePar' => $this->getUser(), 
                    'demandeA' => $profil
                ]);
                
                if ($amitie) 
                {
                    $amitie = $amitie;
                }
                else
                {
                    $amitie = null;
                }
                
                ///je cherche l'amitié bloque
                $amitieBloque = $this->amitieRepository->rechercheAmitieBloque($this->getUser(), $profil);
                
                if ($amitieBloque != null) 
                {
                    if ($amitieBloque[0]->isBloque() == 1) 
                    {
                        $amitieBloque = $amitieBloque[0];
                    }
                }
                else
                {
                    $amitieBloque = null;
                }

                ///je recupère le signalement
                $signalement = $this->signalementRepository->findOneBy([
                    'signalePar' => $this->getUser(),
                    'compteSignale' => $profil,
                ]);

                if ($signalement) 
                {
                    $signalement = $signalement;
                } else 
                {
                    $signalement = null;
                }
                
                /////je récupère le favori
                $favori = $this->favoriRepository->findOneBy([
                    'moi' => $this->getUser(),
                    'favori' => $profil,
                ]);
                
                if ($favori) 
                {
                    $favori = $favori;
                }
                else
                {
                    $favori = null;
                }
            }
            elseif(($maFormule === ConstantsClass::VIP) && 
                (($saFormule === ConstantsClass::PREMIUM) || ($saFormule === ConstantsClass::GRATUIT)))
            {
                /////je récupère l'amitié
                $amitie = $this->amitieRepository->findOneBy([
                    'demandePar' => $this->getUser(), 
                    'demandeA' => $profil
                ]);
                
                if ($amitie) 
                {
                    $amitie = $amitie;
                }
                else
                {
                    $amitie = null;
                }

                ///je cherche l'amitié bloque
                $amitieBloque = $this->amitieRepository->rechercheAmitieBloque($this->getUser(), $profil);

                if ($amitieBloque != null) 
                {
                    if ($amitieBloque[0]->isBloque() == 1) 
                    {
                        $amitieBloque = $amitieBloque[0];
                    }
                }
                else
                {
                    $amitieBloque = null;
                }

                ///je recupère le signalement
                $signalement = $this->signalementRepository->findOneBy([
                    'signalePar' => $this->getUser(),
                    'compteSignale' => $profil,
                ]);

                if ($signalement) 
                {
                    $signalement = $signalement;
                } else 
                {
                    $signalement = null;
                }

                /////je récupère le favori
                $favori = $this->favoriRepository->findOneBy([
                    'moi' => $this->getUser(),
                    'favori' => $profil,
                ]);
                
                if ($favori) 
                {
                    $favori = $favori;
                }
                else
                {
                    $favori = null;
                }
            }
            elseif (($maFormule === ConstantsClass::PREMIUM) && ($saFormule === ConstantsClass::GRATUIT)) 
            {
                /////je récupère l'amitié
                $amitie = $this->amitieRepository->findOneBy([
                    'demandePar' => $this->getUser(), 
                    'demandeA' => $profil
                ]);
                
                if ($amitie) 
                {
                    $amitie = $amitie;
                }
                else
                {
                    $amitie = null;
                }

                ///je cherche l'amitié bloque
                $amitieBloque = $this->amitieRepository->rechercheAmitieBloque($this->getUser(), $profil);

                if ($amitieBloque != null) 
                {
                    if ($amitieBloque[0]->isBloque() == 1) 
                    {
                        $amitieBloque = $amitieBloque[0];
                    }
                }
                else
                {
                    $amitieBloque = null;
                }

                ///je recupère le signalement
                $signalement = $this->signalementRepository->findOneBy([
                    'signalePar' => $this->getUser(),
                    'compteSignale' => $profil,
                ]);

                if ($signalement) 
                {
                    $signalement = $signalement;
                } else 
                {
                    $signalement = null;
                }

                /////je récupère le favori
                $favori = $this->favoriRepository->findOneBy([
                    'moi' => $this->getUser(),
                    'favori' => $profil,
                ]);
                
                if ($favori) 
                {
                    $favori = $favori;
                }
                else
                {
                    $favori = null;
                }
            }
            elseif(($maFormule === ConstantsClass::GRATUIT) && 
                    (($saFormule === ConstantsClass::PREMIUM) || ($saFormule === ConstantsClass::VIP))
                    )
            {
                $this->addFlash('warning','Ce membre est '.$saFormule.' vous ne pouvez pas afficher son profil');
                return $this->redirectToRoute('nos_formules');
            }
            elseif(($maFormule === ConstantsClass::PREMIUM) && ($saFormule === ConstantsClass::VIP)
            )
            {
                $this->addFlash('warning','Ce membre est '.$saFormule.' vous ne pouvez pas afficher son profil');
                return $this->redirectToRoute('nos_formules');
            }
            

        } else 
        {
            /**
             * @var User
             */
            $user =  $this->getUser();
            $idUser = $user->getId();
            $profil =  $this->userRepository->find($idUser);
            $amitie = null;

            #mes préférences
            $preference = $this->preferenceRepository->findOneBy([
                'user' => $profil
            ]);

            if ($preference) 
            {
                $preference;
            } 
            else 
            {
                $preference = new Preference();
            }
            
            /////liste des amis
            $amis = $this->amitieRepository->rechercheAmisUser($profil);

            #invitation des les groupes
            $invitationsGroupes = $this->membreGroupeRepository->findBy([
                'membre' => $user,
                'invitation' => 1,
            ]);
            
            #je récupère mes groupes
            $mesGroupes = $this->groupeRepository->findBy([
                'createur' => $this->getUser()
            ]);

            /////liste des amis bloqués
            $amisBloques = $this->amitieRepository->rechercheAmisBloques($profil);

            /////liste des demandes
            $amisDemandes = $this->amitieRepository->rechercheAmisDemande($profil);
            
            ///////liste des demandes d'amitiés
            $demandesAmitie = $this->amitieRepository->findBy([
                'demandeA' => $profil,
                'statut' => 1,
            ]);
            
            ////je recuèpères mes favori
            $mesFavoris = $this->favoriRepository->findBy([
                'moi' => $user,
                'etatFavori' => 1,
            ]);

            ////je récupère mes messages privés
            $messagePrives = $this->messagePriveRepository->findBy([
                'membre' => $profil
            ]);

            # je suis leur favori
            $jeSuisLeurFavori = $this->favoriRepository->findBy([
                'favori' => $profil,
                'etatFavori' => 1,
            ]);
        }

        ////je récupère les sexes
        $sexes = $this->sexeRepository->findAll();

        ///je récupère les âges
        $ages = $this->ageRepository->findAll();

        $correspondances = $this->matchingService->findMatchesForCurrentUser();
        
        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('demandeAmitie')->getValue();
        
        return $this->render('profil/afficherProfil.html.twig', [
            'slug' => $slug,
            'ages' => $ages,
            'amis' => $amis,
            'sexes' => $sexes,
            'favori' => $favori,
            'profil' => $profil,
            'amitie' => $amitie,
            'favoris' => $favoris,
            'demandesAmitie' => $demandesAmitie,
            'mesFavoris' => $mesFavoris,
            'mesGroupes' => $mesGroupes,
            'csrf_token' => $csrfToken,
            'preference' => $preference,
            'amisBloques' => $amisBloques,
            'invitations' => $invitations,
            'signalement' => $signalement,
            'amitieBloque' => $amitieBloque,
            'amisDemandes' => $amisDemandes,
            'messagePrives' => $messagePrives,
            'mesTemoignages' => $mesTemoignages,
            'correspondances' => $correspondances,
            'jeSuisLeurFavori' => $jeSuisLeurFavori,
            'invitationsGroupes' => $invitationsGroupes,
        ]);
    }
}
