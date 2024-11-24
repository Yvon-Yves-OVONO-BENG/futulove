<?php

namespace App\Repository;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 *
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $em)
    {
        parent::__construct($registry, Message::class);
    }

    public function save(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


     /**
     * recherche les messages
     */
    public function rechercheMessage(Conversation $conversation): array
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder->select('m')
            ->from(Message::class, 'm')
            ->Where('m.estSupprime = 1')
            ->andWhere('m.conversation = :conversation')
            ->setParameter('conversation', $conversation)
            ->orderBy('m.envoyeLeAt', 'DESC');
        $query = $queryBuilder->getQuery();
        $messages = $query->execute();
        return $messages;
    }

       /**
     * recherche les messages non lus
     */
    public function rechercheMessageNonLus(User $user): array
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder->select('m')
            ->from(Message::class, 'm')
            ->Where('m.estLu = 1')
            ->andWhere('m.estSupprime = 1')
            ->andWhere('m.envoyeA = :envoyeA')
            ->setParameter('envoyeA', $user)
            ->orderBy('m.envoyeLeAt', 'DESC');
        $query = $queryBuilder->getQuery();
        $messages = $query->execute();
        return $messages;
    }


//    /**
//     * @return Message[] Returns an array of Message objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Message
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
