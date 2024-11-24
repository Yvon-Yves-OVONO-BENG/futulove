<?php

namespace App\Repository;

use App\Entity\CigaretteVin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CigaretteVin>
 *
 * @method CigaretteVin|null find($id, $lockMode = null, $lockVersion = null)
 * @method CigaretteVin|null findOneBy(array $criteria, array $orderBy = null)
 * @method CigaretteVin[]    findAll()
 * @method CigaretteVin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CigaretteVinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CigaretteVin::class);
    }

    public function save(CigaretteVin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CigaretteVin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CigaretteVin[] Returns an array of CigaretteVin objects
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

//    public function findOneBySomeField($value): ?CigaretteVin
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
