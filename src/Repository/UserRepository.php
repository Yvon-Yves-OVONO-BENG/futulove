<?php

namespace App\Repository;

use App\Entity\Age;
use App\Entity\Pays;
use App\Entity\Sexe;
use App\Entity\User;
use App\Entity\Amitie;
use App\Entity\SubSystem;
use App\Entity\Preference;
use App\Entity\SchoolYear;
use App\Entity\Signalement;
use App\Entity\ConstantsClass;
use App\Entity\Langue;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $em)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    /**
     * Je cherche les partenaires
     *
     * @param Sexe $sexe
     * @param integer $ageMinimum
     * @param integer $ageLimite
     * @param Pays $pays
     * @return array
     */
    public function jeChercheMonAmeSoeur(Sexe $sexe, int $ageMinimum = 0, int $ageLimite = 0, Pays $pays = null): array
    {
        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.sexe = :sexe')
            ->setParameter('sexe', $sexe);

            if($ageMinimum != 0)
            {
                $qb->andWhere('u.age >= :ageMinimum')
                ->setParameter('ageMinimum', $ageMinimum);
            }

            if($ageLimite != 0)
            {
                $qb->andWhere('u.age <= :ageLimite')
                ->setParameter('ageLimite', $ageLimite);
            }

            if($pays)
            {
                $qb->andWhere('u.pays =:pays')
                ->setParameter('pays', $pays);
            }
           
        return $qb->getQuery()->getResult();
    }

    
    public function listeMembres(int $user)
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
                ->select('u.id AS id, u.nom AS nom')
                ->from(User::class, 'u')
                ->leftJoin(Amitie::class, 'a')
                ->andWhere('a.demandePar = u.id')
                ->andWhere('u.id = :user')
                ->andWhere('a.statut = 2')
                ->setParameters([
                    'user' => $user
                    ])
                ;

        $query = $queryBuilder->getQuery();

        return $query->execute();
    }


    public function compteSignales()
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
                ->select('u.id, u.email, u.photoProfile, u.nomUtilisateur, u.nom, count(s.compteSignale) as compteSignale')
                ->from(User::class, 'u')
                ->innerJoin(Signalement::class, 's')
                ->andWhere('u.id = s.compteSignale')
                ;

        $query = $queryBuilder->getQuery();

        return $query->execute();
    }

   
   public function paginatorQuery()
   {
       return $this->createQueryBuilder('u')
           ->orderBy('u.id', 'ASC')
           ->getQuery()
       ;
   }

   /**
     * Trouver les utilisateurs correspondant aux préférences de l'utilisateur connecté.
     *
     * @param Preference $userPreference
     * @return array
     */
    public function findMatchingUsers(Preference $userPreference): array
    {
        $qb = $this->createQueryBuilder('u');

        if ($userPreference->getPays()) {
            $qb->andWhere('u.pays = :pays')
                ->setParameter('pays', $userPreference->getPays());
        }

        if ($userPreference->getRegion()) {
            $qb->andWhere('u.region = :region')
                ->setParameter('region', $userPreference->getRegion());
        }

        if ($userPreference->getDepartement()) {
            $qb->andWhere('u.departement = :departement')
                ->setParameter('departement', $userPreference->getDepartement());
        }

        if ($userPreference->getVille()) {
            $qb->andWhere('u.ville = :ville')
                ->setParameter('ville', $userPreference->getVille());
        }

        if ($userPreference->getAgeMin()) {
            $qb->andWhere('u.age >= :ageMin')
                ->setParameter('ageMin', $userPreference->getAgeMin());
        }

        if ($userPreference->getAgeMax()) {
            $qb->andWhere('u.age <= :ageMax')
                ->setParameter('ageMax', $userPreference->getAgeMax());
        }

        if ($userPreference->getAgeMin() && $userPreference->getAgeMax()) {
            $qb->andWhere('u.age BETWEEN :ageMin AND :ageMax')
            ->setParameter('ageMin', $userPreference->getAgeMin()->getAge())
            ->setParameter('ageMax', $userPreference->getAgeMax()->getAge());
        }

        if ($userPreference->getGenre()) {
            $qb->andWhere('u.sexe = :sexe')
            ->setParameter('sexe', $userPreference->getGenre());
        }

        if ($userPreference->getCouleurCheveux()) {
            $qb->andWhere('u.couleurCheveux = :couleurCheveux')
            ->setParameter('couleurCheveux', $userPreference->getCouleurCheveux());
        }

        if ($userPreference->getCouleurYeux()) {
            $qb->andWhere('u.couleurYeux = :couleurYeux')
            ->setParameter('couleurYeux', $userPreference->getCouleurYeux());
        }

        if ($userPreference->getTeint()) {
            $qb->andWhere('u.teint = :teint')
            ->setParameter('teint', $userPreference->getTeint());
        }

        if ($userPreference->getTaille()) {
            $qb->andWhere('u.taille = :taille')
            ->setParameter('taille', $userPreference->getTaille());
        }

        if ($userPreference->getPoids()) {
            $qb->andWhere('u.poids = :poids')
            ->setParameter('poids', $userPreference->getPoids());
        }

        if ($userPreference->getCorpulance()) {
            $qb->andWhere('u.corpulance = :corpulance')
            ->setParameter('corpulance', $userPreference->getCorpulance());
        }

        if ($userPreference->getCigarette()) {
            $qb->andWhere('u.fume = :cigarette')
            ->setParameter('cigarette', $userPreference->getCigarette());
        }

        if ($userPreference->getVin()) {
            $qb->andWhere('u.boisson = :vin')
            ->setParameter('vin', $userPreference->getVin());
        }

        if ($userPreference->getLangue()) {
            $qb->innerJoin(Langue::class, 'l')
            ->andWhere('l.langue LIKE %langue%')
            ->setParameter('langue', $userPreference->getLangue());
        }

        if ($userPreference->getAnimauxDeCompagnie()) {
            $qb->andWhere('u.animauxDeCompagnie LIKE %animauxDeCompagnie%')
            ->setParameter('animauxDeCompagnie', $userPreference->getAnimauxDeCompagnie());
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
