<?php

namespace App\Repository;

use App\Entity\AdoreCommentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdoreCommentaire>
 *
 * @method AdoreCommentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdoreCommentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdoreCommentaire[]    findAll()
 * @method AdoreCommentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdoreCommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdoreCommentaire::class);
    }

    public function save(AdoreCommentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AdoreCommentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AdoreCommentaire[] Returns an array of AdoreCommentaire objects
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

//    public function findOneBySomeField($value): ?AdoreCommentaire
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
