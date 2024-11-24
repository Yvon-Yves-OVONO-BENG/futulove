<?php

namespace App\Controller\Photo;

use App\Entity\Photo;
use App\Entity\User;
use App\Form\PhotType;
use App\Service\PhotoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Connectez-vous')]
class AjoutPhotoController extends AbstractController
{
    public function __construct(
        protected PhotoService $photoService,
        protected EntityManagerInterface $em
    )
    {}

    #[Route('/ajout-photo', name: 'ajout_photo')]
    public function ajoutPhoto(Request $request): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();

        $photo = new Photo;

        $form = $this->createForm(PhotType::class, $photo);
        $form->handleRequest($request);

        ////je soumet mon formulaire
        if ($form->isSubmitted()) 
        {
            return $this->photoService->handleProfilFormData($form, $user);
            
        }

        return $this->render('ajout_photo/ajoutPhoto.html.twig', [
            "photoForm" => $form->createView()
        ]);
    }
}
