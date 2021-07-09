<?php

namespace App\Repository;

use App\Entity\RemindingEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RemindingEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method RemindingEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method RemindingEvent[]    findAll()
 * @method RemindingEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemindingEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RemindingEvent::class);
    }

    // /**
    //  * @return RemindingEvent[] Returns an array of RemindingEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RemindingEvent
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
