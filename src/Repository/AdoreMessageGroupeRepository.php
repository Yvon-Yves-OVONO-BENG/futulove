<?php

namespace App\Repository;

use App\Entity\AdoreMessageGroupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdoreMessageGroupe>
 *
 * @method AdoreMessageGroupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdoreMessageGroupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdoreMessageGroupe[]    findAll()
 * @method AdoreMessageGroupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdoreMessageGroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdoreMessageGroupe::class);
    }

    public function save(AdoreMessageGroupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AdoreMessageGroupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AdoreMessageGroupe[] Returns an array of AdoreMessageGroupe objects
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

//    public function findOneBySomeField($value): ?AdoreMessageGroupe
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
