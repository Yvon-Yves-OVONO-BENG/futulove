<?php

namespace App\Repository;

use App\Entity\Amitie;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Amitie>
 *
 * @method Amitie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Amitie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Amitie[]    findAll()
 * @method Amitie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmitieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $em)
    {
        parent::__construct($registry, Amitie::class);
        
    }

    public function save(Amitie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Amitie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
    /**
     * je cherche les amis d'un membre
     *
     * @param User $user
     * @return array
     */
    public function rechercheAmisUser(User $user, $statut = 2, $bloque = 0)
    {
        return $this->createQueryBuilder('a')
            ->where('a.demandePar = :user OR a.demandeA = :user')
            ->andWhere('a.statut = :statut')
            ->andWhere('a.bloque = :bloque')
            ->setParameter('user', $user)
            ->setParameter('statut', $statut)
            ->setParameter('bloque', $bloque)
            ->getQuery()
            ->getResult();
    }

    /**
     * fonction qui cherche les amis bloques
     *
     * @param User $user
     * @param integer $statut
     * @param integer $bloque
     * @return array
     */
    public function rechercheAmisBloques(User $user, $statut = 2, $bloque = 1): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.demandePar = :user OR a.demandeA = :user')
            ->andWhere('a.statut = :statut')
            ->andWhere('a.bloque = :bloque')
            ->setParameter('user', $user)
            ->setParameter('statut', $statut)
            ->setParameter('bloque', $bloque)
            ->getQuery()
            ->getResult();
    }

    public function rechercheAmisDemande(User $user): array
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder->select('a')
            ->from(Amitie::class, 'a')
            // ->Where('a.demandePar = :user')
            ->where('a.demandeA = :user')
            ->andWhere('a.statut = 1')
            ->andWhere('a.bloque = 0')
            ->setParameter('user', $user);
        $query = $queryBuilder->getQuery();
        $amis = $query->execute();
        return $amis;
    }

    /**
     * je cherche l'amitié
     *
     * @param User $demandePar
     * @param User $demandeA
     * @return array
     */
    public function rechercheAmitie(User $demandePar, User $demandeA): array
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder->select('a')
            ->from(Amitie::class, 'a')
            ->Where('((a.demandePar = :demandePar) or (a.demandeA = :demandePar))') 
            ->andWhere('((a.demandePar = :demandeA) or (a.demandeA = :demandeA))')
            ->andWhere('a.statut = 2')
            ->setParameters([
                'demandePar' => $demandePar,
                'demandeA' => $demandeA,
            ]);
        $query = $queryBuilder->getQuery();
        $amis = $query->execute();
        return $amis;
    }

    public function testeAmitie(User $demandePar, User $demandeA, $statut = 2, $bloque = 0): array
    {
        return $this->createQueryBuilder('a')
            ->where('(a.demandePar = :demandePar AND a.demandeA = :demandeA)') 
            ->orWhere('(a.demandePar = :demandeA AND a.demandeA = :demandePar)') 
            ->andWhere('a.statut = :statut')
            ->andWhere('a.bloque = :bloque')
            ->setParameter('demandePar', $demandePar)
            ->setParameter('demandeA', $demandeA)
            ->setParameter('statut', $statut)
            ->setParameter('bloque', $bloque)
            ->getQuery()
            ->getResult();
    }


    /**
     * je cherche le compte bloqué
     *
     * @param User $demandePar
     * @param User $demandeA
     * @return array
     */
    public function rechercheAmitieBloque(User $demandePar, User $demandeA): array
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder->select('a')
            ->from(Amitie::class, 'a')
            ->Where('((a.demandePar = :demandePar) or (a.demandeA = :demandePar))') 
            ->andWhere('((a.demandePar = :demandeA) or (a.demandeA = :demandeA))')
            ->setParameters([
                'demandePar' => $demandePar,
                'demandeA' => $demandeA,
            ]);
        $query = $queryBuilder->getQuery();
        $amitieBloque = $query->execute();
        return $amitieBloque;
    }

    

//    /**
//     * @return Amitie[] Returns an array of Amitie objects
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

//    public function findOneBySomeField($value): ?Amitie
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
