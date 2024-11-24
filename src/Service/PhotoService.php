<?php

namespace App\Service;

use App\Entity\User;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PhotoService
{
    public function __construct(
        private EntityManagerInterface $em,
        private Environment $environment,
        private ParameterBagInterface $parameters
    ) {}

    public function handleProfilFormData(FormInterface $form, User $user): JsonResponse
    {
        if ($form->isValid()) 
        {
            return $this->handleValidForm($form, $user);
        } 
        else 
        {
            return $this->handleInvalidForm($form);
        }
    }


    private function handleValidForm(FormInterface $form, User $user) : JsonResponse
    {
        /** @var User $user */
        
        $photo = $form->getData();

        /** @var UploadedFile $nomPhoto */
        $nomPhoto = $form['nomPhoto']->getData();

        $newFileName = $this->renameUploadedFile($nomPhoto, $this->parameters->get('photoUsers.upload_directory'));
        $photo->setNomPhoto($newFileName);

        $photo->setUser($user);
        $this->em->persist($photo);
        $this->em->flush();

        return new JsonResponse([
            'code' => User::PHOTO_ADDED_SUCCESSFULLY,
            'html' => $this->environment->render('ajout_photo/ajoutPhoto.html.twig', [
                'photo' => $photo,
            ]
            )
        ]);
    }


    private function handleInvalidForm(FormInterface $photo) : JsonResponse
    {
        return new JsonResponse([
            'code' => User::PHOTO_INVALID_FORM,
            'errors' => $this->getErrorMessages($photo)
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