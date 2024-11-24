<?php

namespace App\Controller;

use App\Entity\ConstantsClass;
use App\Repository\AgeRepository;
use App\Repository\SexeRepository;
use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use App\Repository\FavoriRepository;
use App\Repository\PaysRepository;
use App\Repository\TemoignageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\RouterInterface;

class AccueilController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected AgeRepository $ageRepository,
        protected PaginatorInterface $paginator,
        protected PaysRepository $paysRepository,
        protected UserRepository $userRepository,
        protected SexeRepository $sexeRepository,
        protected FavoriRepository $favoriRepository,
        protected AmitieRepository $amitieRepository,
        protected TemoignageRepository $temoignageRepository
        ){}

    #[Route('/', name: 'accueil')]
    public function accueil(Request $request): Response
    {
        
        if ($this->getUser()) 
        {
            /**
             * @var User
             */
            $user = $this->getUser();
            $id = $user->getId();
        }
        else
        {
            $id = 0;
        }

        $membres = [];
        ///liste des membres
        $utilisateurs = $this->userRepository->findBy([], ['id' => 'DESC']);

        foreach ($utilisateurs as $utilisateur) 
        {
            if ($utilisateur->getRoles()[0] != ConstantsClass::ROLE_ADMINISTRATEUR) 
            {
                $membres[] = $utilisateur;
            }
        }

        $lesMembres = [];

        $tousLesMembres = $this->userRepository->findAll();
        foreach ($tousLesMembres as $membre) 
        {
            if ($membre->getRoles()[0] != ConstantsClass::ROLE_ADMINISTRATEUR) 
            {
                $lesMembres[] = $membre;
            }
        }

        //////j'extrait les 5 derniers membres enregistrés de la table
        $lesDixDerniersmembres = $this->userRepository->findBy([],['id' => 'DESC'],10,0);

        #je récupère mes témoignages
        $temoignages = $this->temoignageRepository->findBy([
            'supprime' => 0 ], ['id' => 'DESC']);
        
        //////je déclare la pagination
        $pagination = $this->paginator->paginate(
            $this->userRepository->paginatorQuery(),
            $request->query->get('page', 1),
            13
        );

        /**
         * @var User
         */
        $user = $this->getUser();

        //je met l'utilisateur hors ligne dans le tchat
        if ($user) {
            $user->setEnligne(1);
            $this->em->persist($user);
            $this->em->flush();
        }

        //je vide la variable destinataire et conversation dans la session
        $session = $request->getSession();
        $session->remove('destinataire');
        $session->remove('conversation');

        ///je récupères les âges
        $ages = $this->ageRepository->findAll();
        $pays = $this->paysRepository->findAll();
        
        ////je récupère les sexes de la BD
        $sexes = $this->sexeRepository->findAll();

        return $this->render('accueil/index.html.twig', [
            "id" => $id,
            "ages" => $ages,
            "pays" => $pays,
            "sexes" => $sexes,
            "membres" => $membres,
            "lesMembres" => $lesMembres,
            "pagination" => $pagination,
            "temoignages" => $temoignages,
            "lesDixDerniersmembres" => $lesDixDerniersmembres,
        ]);
    }
}
