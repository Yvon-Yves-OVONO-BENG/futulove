<?php

namespace App\Repository;

use App\Entity\CouleurCheveux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CouleurCheveux>
 *
 * @method CouleurCheveux|null find($id, $lockMode = null, $lockVersion = null)
 * @method CouleurCheveux|null findOneBy(array $criteria, array $orderBy = null)
 * @method CouleurCheveux[]    findAll()
 * @method CouleurCheveux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouleurCheveuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CouleurCheveux::class);
    }

    public function save(CouleurCheveux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CouleurCheveux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CouleurCheveux[] Returns an array of CouleurCheveux objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CouleurCheveux
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
