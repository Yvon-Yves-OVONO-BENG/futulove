<?php

namespace App\Controller\Amitie;

use App\Entity\User;
use App\Repository\AmitieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
#[Route('/amitie')]
class BloquerAmitieController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected AmitieRepository $amitieRepository,
    ){}

    #[Route('/bloquer-amitie', name: 'bloquer_amitie')]
    public function bloquerAmitie(Request $request, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);
        $memberId = $data['memberId'];

        $profil = $this->userRepository->find($memberId);

        $amitiePar = $this->amitieRepository->findOneBy([
            'demandePar' => $profil, 
            'demandeA' => $this->getUser()
        ]);

        $amitieA = $this->amitieRepository->findOneBy([
            'demandeA' => $profil, 
            'demandePar' => $this->getUser()
        ]);

        if ($amitieA) {
            $amitie = $amitieA;
        } else {
            $amitie = $amitiePar;
        }
        
        if ($amitie) {
            $amitie->setBloque(true);
            $em->persist($amitie);
            $em->flush();

            return new JsonResponse(['success' => true]);
        }

        return new JsonResponse(['success' => false], 404);
    }
}
