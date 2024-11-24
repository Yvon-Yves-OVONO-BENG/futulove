<?php

namespace App\Service;

use App\Entity\User;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ProfilService
{
    public function __construct(
        private EntityManagerInterface $em,
        private Environment $environment,
        private ParameterBagInterface $parameters
    ) {}

    public function handleProfilFormData(FormInterface $form): JsonResponse
    {
        if ($form->isValid()) {
            return $this->handleValidForm($form);
        } else {
            return $this->handleInvalidForm($form);
        }
    }


    private function handleValidForm(FormInterface $form) : JsonResponse
    {
        /** @var User $user */
        $profil = $form->getData();

        /** @var UploadedFile $photoProfile */
        $photoProfile = $form['photoProfile']->getData();
        // $photoCouverture = $form['photoCouverture']->getData();

        $newFileName = $this->renameUploadedFile($photoProfile, $this->parameters->get('photoProfil.upload_directory'));
        // $newFileNameCouverture = $this->renameUploadedFile($photoCouverture, $this->parameters->get('photoCouverture.upload_directory'));
        $profil
            ->setPhotoProfile($newFileName)
            // ->setPhotoCouverture($newFileNameCouverture)
            ;

        $this->em->persist($profil);
        $this->em->flush();

        return new JsonResponse([
            'code' => User::PHOTO_ADDED_SUCCESSFULLY,
            'html' => $this->environment->render('profil/remplissageProfil.html.twig', [
                'profil' => $profil,
            ]
            )
        ]);
    }


    private function handleInvalidForm(FormInterface $profil) : JsonResponse
    {
        return new JsonResponse([
            'code' => User::PHOTO_INVALID_FORM,
            'errors' => $this->getErrorMessages($profil)
        ]);
    }

    /**
     * Undocumented function
     *
     * @param UploadedFile $uploadedFile
     * @param string $directory
     * @return string
     */
    private function renameUploadedFile(UploadedFile $uploadedFile, string $directory) : string
    {
        $newFileName = uniqid(more_entropy: true) . ".{$uploadedFile->guessExtension()}";
        $uploadedFile->move($directory, $newFileName);

        return $newFileName;
    }


    private function getErrorMessages(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }


}