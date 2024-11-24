<?php

namespace App\Repository;

use App\Entity\AdoreTemoignage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdoreTemoignage>
 *
 * @method AdoreTemoignage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdoreTemoignage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdoreTemoignage[]    findAll()
 * @method AdoreTemoignage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdoreTemoignageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdoreTemoignage::class);
    }

    public function save(AdoreTemoignage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AdoreTemoignage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AdoreTemoignage[] Returns an array of AdoreTemoignage objects
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

//    public function findOneBySomeField($value): ?AdoreTemoignage
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
