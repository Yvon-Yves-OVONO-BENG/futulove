<?php

namespace App\Repository;

use App\Entity\PhotoMessageGroupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PhotoMessageGroupe>
 *
 * @method PhotoMessageGroupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoMessageGroupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoMessageGroupe[]    findAll()
 * @method PhotoMessageGroupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoMessageGroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoMessageGroupe::class);
    }

    public function save(PhotoMessageGroupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PhotoMessageGroupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PhotoMessageGroupe[] Returns an array of PhotoMessageGroupe objects
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

//    public function findOneBySomeField($value): ?PhotoMessageGroupe
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
