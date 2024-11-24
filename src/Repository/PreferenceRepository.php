<?php

namespace App\Repository;

use App\Entity\Preference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Preference>
 *
 * @method Preference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Preference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Preference[]    findAll()
 * @method Preference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Preference::class);
    }

    public function save(Preference $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Preference $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


     /**
     * Trouver les utilisateurs correspondant aux préférences de l'utilisateur connecté.
     *
     * @param Preference $userPreference
     * @return array
     */
    public function findMatchingUsers(Preference $userPreference): array
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.user', 'u')
            ->where('p.genre = :sexe')
            ->andWhere('u.age BETWEEN :ageMin AND :ageMax')
            ->setParameter('sexe', $userPreference->getGenre())
            ->setParameter('ageMin', $userPreference->getAgeMin())
            ->setParameter('ageMax', $userPreference->getAgeMax());
        
        // Ajouter des critères supplémentaires si nécessaire, comme la ville
        if ($userPreference->getVille()) {
            $qb->andWhere('u.ville = :ville')
                ->setParameter('ville', $userPreference->getVille());
        }

        return $qb->getQuery()->getResult();
    }


//    /**
//     * @return Preference[] Returns an array of Preference objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Preference
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
