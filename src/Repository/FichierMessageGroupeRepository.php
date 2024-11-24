<?php

namespace App\Repository;

use App\Entity\FichierMessageGroupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FichierMessageGroupe>
 *
 * @method FichierMessageGroupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichierMessageGroupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichierMessageGroupe[]    findAll()
 * @method FichierMessageGroupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichierMessageGroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichierMessageGroupe::class);
    }

    public function save(FichierMessageGroupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FichierMessageGroupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FichierMessageGroupe[] Returns an array of FichierMessageGroupe objects
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

//    public function findOneBySomeField($value): ?FichierMessageGroupe
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
