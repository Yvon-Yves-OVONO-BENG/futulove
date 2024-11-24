<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Favori;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Favori>
 *
 * @method Favori|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favori|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favori[]    findAll()
 * @method Favori[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $em)
    {
        parent::__construct($registry, Favori::class);
    }

    public function save(Favori $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Favori $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * recherche des favories
    */
    public function rechercheFavori(User $user): array
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder->select('f')
            ->from(Favori::class, 'f')
            ->Where('f.moi = :user')
            ->setParameter('user', $user);
        $query = $queryBuilder->getQuery();
        $favori = $query->execute();
        return $favori;
    }

//    /**
//     * @return Favori[] Returns an array of Favori objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Favori
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
