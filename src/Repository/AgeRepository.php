<?php

namespace App\Repository;

use App\Entity\Age;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Age>
 *
 * @method Age|null find($id, $lockMode = null, $lockVersion = null)
 * @method Age|null findOneBy(array $criteria, array $orderBy = null)
 * @method Age[]    findAll()
 * @method Age[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $em)
    {
        parent::__construct($registry, Age::class);
    }

    public function save(Age $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Age $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


     /**
     * recherche les ages
     */
    public function rechercheAgeSup(int $age): array
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder->select('a')
            ->from(Age::class, 'a')
            ->Where('a.age > :age')
            ->setParameter('age', $age)
            ->orderBy('a.age', 'DESC');
        $query = $queryBuilder->getQuery();
        $age = $query->execute();
        return $age;
    }

//    /**
//     * @return Age[] Returns an array of Age objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Age
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
