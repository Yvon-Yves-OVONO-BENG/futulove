<?php

namespace App\Controller;

use App\Repository\SexeRepository;
use App\Repository\UserRepository;
use App\Repository\TemoignageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AproposController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository, 
        protected SexeRepository $sexeRepository,
        protected TemoignageRepository $temoignageRepository
    ){}

    #[Route('/apropos', name: 'apropos')]
    public function apropos(): Response
    {
        $temoignages = $this->temoignageRepository->findBy([
            'supprime' => 0
        ]);

        $total = $this->userRepository->findAll();
        $enligne = $this->userRepository->findBy([
            'enLigne' => 0
        ]);
        $hommes = $this->userRepository->findBy([
            'sexe' => $this->sexeRepository->find(2),
            'enLigne' => 0
        ]);
        $femmes = $this->userRepository->findBy([
            'sexe' => $this->sexeRepository->find(1),
            'enLigne' => 0
        ]);

        return $this->render('apropos/apropos.html.twig', [
            'total' => $total,
            'enligne' => $enligne,
            'hommes' => $hommes,
            'femmes' => $femmes,
            'temoignages' => $temoignages
        ]);
    }
}
