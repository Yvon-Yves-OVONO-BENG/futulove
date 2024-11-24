<?php

namespace App\Repository;

use App\Entity\PhotoPostProfil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PhotoPostProfil>
 *
 * @method PhotoPostProfil|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoPostProfil|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoPostProfil[]    findAll()
 * @method PhotoPostProfil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoPostProfilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoPostProfil::class);
    }

    public function save(PhotoPostProfil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PhotoPostProfil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PhotoPostProfil[] Returns an array of PhotoPostProfil objects
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

//    public function findOneBySomeField($value): ?PhotoPostProfil
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
