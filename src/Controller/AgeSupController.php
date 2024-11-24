<?php

namespace App\Controller;

use App\Repository\AgeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

// #[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class AgeSupController extends AbstractController
{
    public function __construct(
        protected AgeRepository $ageRepository,
    )
    {}

    #[Route('/chercher-age-sup', name: 'chercher_age_sup')]
    public function chercherAgeSup(Request $request): JsonResponse
    {
        ///je récupères les âges
        // dd($request->request->get('ageMinimum'));
        $age = $this->ageRepository->find($request->request->get('ageMinimum'));
        $ages = $this->ageRepository->rechercheAgeSup($age->getAge());
        if ($ages) {
           $dataTmp =  array();
           foreach ($ages as $age) {
               $dataTmp[] = [
                   'age' => $age->getAge(),
                   'id' => $age->getId()
               ];
           }
           $json = new JsonResponse($dataTmp);
           return $json;
        }
        return $this->json([
            'code' => 200,
            'message' => 'success'
        ], 200); 
    }
}
