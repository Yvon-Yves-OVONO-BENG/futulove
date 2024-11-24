<?php

namespace App\Repository;

use App\Entity\CommentairePostProfil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommentairePostProfil>
 *
 * @method CommentairePostProfil|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentairePostProfil|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentairePostProfil[]    findAll()
 * @method CommentairePostProfil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentairePostProfilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentairePostProfil::class);
    }

    public function save(CommentairePostProfil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CommentairePostProfil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CommentairePostProfil[] Returns an array of CommentairePostProfil objects
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

//    public function findOneBySomeField($value): ?CommentairePostProfil
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
