<?php

namespace App\Controller;

use App\Entity\Age;
use App\Entity\ConstantsClass;
use App\Repository\AgeRepository;
use App\Repository\SexeRepository;
use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use App\Repository\FavoriRepository;
use App\Repository\PaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// #[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class ListeMembresController extends AbstractController
{
    public function __construct(
        protected AgeRepository $ageRepository,
        protected SexeRepository $sexeRepository,
        protected UserRepository $userRepository,
        protected FavoriRepository $favoriRepository,
        protected AmitieRepository $amitieRepository,
        protected PaginatorInterface $paginator,
        protected RouterInterface $router,
        protected PaysRepository $paysRepository,
    ){}

    #[Route('/liste-membres', name: 'liste_membres')]
    public function listeMembres(Request $request): Response
    {
        // $collection = $this->router->getRouteCollection();
        // $allRoutes = $collection->all();
        // dd($allRoutes);

        $id = null ;
        $favori = null ;
        $amities = null ;
        
        $membres = [];
        $lesMembres = $this->userRepository->findBy([],['id' => 'DESC']);

        foreach ($lesMembres as $membre) 
        {

            if ((in_array(ConstantsClass::ROLE_MEMBRE, $membre->getRoles()))) 
            {
                $membres[] = $membre;
            }
        }

        //////je déclare la pagination
        $pagination = $this->paginator->paginate(
            $membres,
            $request->query->get('page', 1),
            8
        );

        if ($this->getUser()) 
        {
            /**
             * @var User
             */
            $user = $this->getUser();
            $id = $user->getId();
            /**
             * @var User
             */
            $utilisateurDemandeur = $this->getUser();
            
            $profil = $this->userRepository->find($id);

            /////je récupère l'amitié
            $amities = $this->amitieRepository->findBy([
                'demandePar' => $utilisateurDemandeur
            ]);
            
            if ($amities) 
            {
                $amities = $amities;
            }
            else
            {
                $amities = 0;
            }

            /////je récupère le favori
            $favori = $this->favoriRepository->findBy([
                'moi' => $utilisateurDemandeur,
                'favori' => $profil,
            ]);

            if ($favori) 
            {
                $favori = $favori;
            }
            else
            {
                $favori = 0;
            }

        }


        //je récupère les sexes
        $sexes = $this->sexeRepository->findAll();

        if ($request->request->has('jeTrouveMonPartenaire')) 
        {
            $jeCherche = $request->request->get('jeCherche');
            $ageDebut = $request->request->get('ageDebut');
            $ageFin = $request->request->get('ageFin');

            //////je récupère le sexe recherché
            $sexe = $this->sexeRepository->find($jeCherche);

            $membres = $this->userRepository->jeChercheMonPartenaire($sexe, $ageDebut, $ageFin);

            //////je déclare la pagination
            $pagination = $this->paginator->paginate(
                $this->userRepository->jeChercheMonPartenaire($sexe, $ageDebut, $ageFin),
                $request->query->get('page', 1),
                13
            );
        }

        if ($this->getUser())
        {
            /**
             * @var User
             */
            $user = $this->getUser();
            $id = $user->getId();
            ///liste des membres
            $membres = [];

            $lesMembres = $this->userRepository->findBy([],['id' => 'DESC']);

            foreach ($lesMembres as $membre) 
            {
                /**
                 * @var User
                 */
                $user = $this->getUser();

                if (($membre->getId() != $user->getId()) && (in_array(ConstantsClass::ROLE_MEMBRE, $membre->getRoles()))) 
                {
                    $membres[] = $membre;
                }
            }

            //////je déclare la pagination
            $pagination = $this->paginator->paginate(
                $membres,
                $request->query->get('page', 1),
                8
            );
        }
        
        ///je récupère les âges
        $ages = $this->ageRepository->findAll();
        $pays = $this->paysRepository->findAll();

        return $this->render('liste_membres/listeMembres.html.twig', [
            'id' => $id,
            'ages' => $ages,
            'pays' => $pays,
            'sexes' => $sexes,
            'favori' => $favori,
            'amities' => $amities,
            'membres' => $membres,
            'pagination' => $pagination,
        ]);
    }
}
