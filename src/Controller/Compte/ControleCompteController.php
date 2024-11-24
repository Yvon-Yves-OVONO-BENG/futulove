<?php

namespace App\Controller\Compte;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: 'security')]
class ControleCompteController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        )
    {}

    #[Route(path: '/compte', name: 'compte_actif')]
    public function compteActif(Request $request): Response
    {
        $email = $request->request->get('email');
        $user = $this->userRepository->findOneBy([
            'email' => $email
        ]);
        $test = 0;
        $aucun = 0;
        if ($user) {
            if ($user->isIsVerified() == 1) {
                $test = 1;
            }
        }else{
            $aucun = 1;
        }
        $data[] = [
            'test' => $test,
            'aucun' => $aucun,
        ];
        
        $json = new JsonResponse($data);
        // $resultat = $json->getContent();
        return $json;
    }
}
