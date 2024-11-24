<?php

namespace App\Controller\Amitie;

use DateTime;
use App\Repository\UserRepository;
use App\Repository\AmitieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/amitie')]
class AccepterAmitieController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected AmitieRepository $amitieRepository,
    ){}

    #[Route('/accepter-amitie/{id}', name: 'accepter_amitie')]
    public function accepterAmitie(int $id): Response
    {
        ///je recupère le demane d'amitié
        $profil = $this->userRepository->find($id);
        $amitie = $this->amitieRepository->findOneBy([
            'demandePar' => $profil, 
            'demandeA' => $this->getUser()
        ]);
        
        /////je recupère la date de jour
        $date = new DateTime('now');

        ///je met à njour l'amitié
        $amitie->setStatut(2)
        ->setAmiDepuisAt($date);

        /////je persist
        $this->em->persist($amitie);
        $this->em->flush();

        return new JsonResponse(['success' => true]);

    }
}
