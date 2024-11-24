<?php

namespace App\Repository;

use App\Entity\StatutMatrimonial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatutMatrimonial>
 *
 * @method StatutMatrimonial|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatutMatrimonial|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatutMatrimonial[]    findAll()
 * @method StatutMatrimonial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutMatrimonialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutMatrimonial::class);
    }

    public function save(StatutMatrimonial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StatutMatrimonial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return StatutMatrimonial[] Returns an array of StatutMatrimonial objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StatutMatrimonial
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
