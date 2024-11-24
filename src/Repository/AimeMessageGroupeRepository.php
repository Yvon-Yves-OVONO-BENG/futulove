<?php

namespace App\Repository;

use App\Entity\AimeMessageGroupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AimeMessageGroupe>
 *
 * @method AimeMessageGroupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method AimeMessageGroupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method AimeMessageGroupe[]    findAll()
 * @method AimeMessageGroupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AimeMessageGroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AimeMessageGroupe::class);
    }

    public function save(AimeMessageGroupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AimeMessageGroupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AimeMessageGroupe[] Returns an array of AimeMessageGroupe objects
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

//    public function findOneBySomeField($value): ?AimeMessageGroupe
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
