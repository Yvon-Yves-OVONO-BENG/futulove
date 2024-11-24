<?php

namespace App\Service;

use App\Entity\Preference;
use App\Entity\User;
use App\Repository\PreferenceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class MatchingService
{
    public function __construct(
        protected Security $security,
        protected UserRepository $userRepository,
        protected TranslatorInterface $translator,
        protected PreferenceRepository $preferenceRepository, 
        ){}

    /**
     * Trouver des correspondances pour l'utilisateur connecté.
     *
     * @return array
     */
    public function findMatchesForCurrentUser(): array
    {
        /** @var User $currentUser */
        $currentUser = $this->security->getUser();

        if (!$currentUser) {
            throw new \LogicException($this->translator->trans('Veuillez connecter'));
        }

        $userPreference = $this->preferenceRepository->findOneBy([
            'user' => $currentUser
        ]);

        if ($userPreference) {
            // throw new \LogicException($this->translator->trans("Vous n'avez pas de préferences"));
            // $userPreference = new Preference();

            return $this->userRepository->findMatchingUsers($userPreference);
        }

        return [];
        
    }
}