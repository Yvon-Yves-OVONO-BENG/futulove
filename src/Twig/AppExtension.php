<?php

namespace App\Twig;

use App\Entity\User;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Entity\Temoignage;
use App\Entity\Commentaire;
use Twig\Extension\AbstractExtension;
use App\Service\GroupeInvitationService;
use App\Repository\TemoignageRepository;
use App\Repository\CommentaireRepository;

class AppExtension extends AbstractExtension 
{
    public function __construct(
        protected TemoignageRepository $temoignageRepository,
        protected CommentaireRepository $commentaireRepository,
        protected GroupeInvitationService $groupeInvitationService,
    )
    {}

    #filtre qui permet de segmenter un nombre en bloc de 3 commençant pas ma froite
    public function getFilters()
    {
        return [
            new TwigFilter('number_format', [$this, 'numberFormat']),
            new TwigFilter('age', [$this, 'calculeAge']),
            new TwigFilter('truncate_40', [$this, 'truncate40']),
            new TwigFunction('estAimeCommentaire', [$this, 'estAimeCommentaireParUser']),
            new TwigFunction('estAdoreCommentaire', [$this, 'estAdoreCommentaireParUser']),
            new TwigFunction('estAimeTemoignage', [$this, 'estAimeTemoignageParUser']),
            new TwigFunction('estAdoreTemoignage', [$this, 'estAdoreTemoignageParUser']),
            new TwigFunction('estDejaInvite', [$this, 'estDejaInvite']),
            new TwigFilter('tempsPublication', [$this, 'tempsPublication']),
        ];

    }

    public function numberFormat($number)
    {
        #j'utilise la fonction
        return number_format($number, 0, '', ' ');
    }

    #filtre qui permet de calculer l'âge
    public function calculeAge(\DateTimeInterface $dateNaissance): int
    {
        $aujourdhui = new \DateTime();
        $age = $aujourdhui->diff($dateNaissance)->y;

        return $age;
    }

    #filtre qui affiche 40% du texte
    public function truncate40(string $text): string
    {
        #calculer 40% de la longueur du text
        $length = strlen($text);
        $truncateLength = intval($length * 0.4);

        #retourne le texte tronqué
        return substr($text, 0, $truncateLength);
    }

    /**
     * function qui teste si un commentaire est aimé par un user
     *
     * @param Commentaire $commentaire
     * @param User $user
     * @return boolean
     */
    public function estAimeCommentaireParUser(Commentaire $commentaire, User $user): bool
    {
        return $commentaire->getAimeCommentaires()->contains($user);
    }

    /**
     * fonction qui teste si un commentzire est adoré par un user
     *
     * @param Commentaire $commentaire
     * @param User $user
     * @return boolean
     */
    public function estAdoreCommentaireParUser(Commentaire $commentaire, User $user): bool
    {
        return $commentaire->getAdoreCommentaires()->contains($user);
    }

    /**
     * function qui test si un témoignage est aime par un user
     *
     * @param Temoignage $temoignage
     * @param User $user
     * @return boolean
     */
    public function estAimeTemoignageParUser(Temoignage $temoignage, User $user): bool
    {
        return $temoignage->getAimeTemoignages()->contains($user);
    }

    /**
     * function qui test si un témoignage est adoré par un user
     *
     * @param Temoignage $temoignage
     * @param User $user
     * @return boolean
     */
    public function estAdoreTemoignageParUser(Temoignage $temoignage, User $user): bool
    {
        return $temoignage->getAdoreTemoignages()->contains($user);
    }

    /**
     * fonction qui verifie si un membre est déjà invité
     *
     * @param [type] $groupe
     * @param [type] $user
     * @return boolean
     */
    public function estDejaInvite($groupe, $user): bool
    {
        return $this->groupeInvitationService->estDejaInvite($groupe, $user);
    }


    public function tempsPublication(\DateTime $dateTime)
    {
        $differencePublication = (new \Datetime())->diff($dateTime);

        if ($differencePublication->y > 0) 
        {
            return $differencePublication->y . ' an' .($differencePublication->y > 1 ? 's' : '');
        } 
        elseif ($differencePublication->m > 0) 
        {
            return $differencePublication->m . ' mois' ;
        } 
        elseif ($differencePublication->d > 0) 
        {
            return $differencePublication->d . ' jour' .($differencePublication->d > 1 ? 's' : '');
        } 
        elseif ($differencePublication->h > 0) 
        {
            return $differencePublication->h . ' heure' .($differencePublication->h > 1 ? 's' : '');
        }
        elseif ($differencePublication->i > 0) 
        {
            return $differencePublication->i . ' minute' .($differencePublication->i > 1 ? 's' : '');
        } 
        else
        {
            return "moins d'une minute";
        }
        
    }



}