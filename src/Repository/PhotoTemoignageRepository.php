<?php

namespace App\Repository;

use App\Entity\PhotoTemoignage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PhotoTemoignage>
 *
 * @method PhotoTemoignage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoTemoignage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoTemoignage[]    findAll()
 * @method PhotoTemoignage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoTemoignageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoTemoignage::class);
    }

    public function save(PhotoTemoignage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PhotoTemoignage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PhotoTemoignage[] Returns an array of PhotoTemoignage objects
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

//    public function findOneBySomeField($value): ?PhotoTemoignage
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
