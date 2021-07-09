<?php

namespace App\Repository;

use App\Entity\PatientEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PatientEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatientEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatientEvent[]    findAll()
 * @method PatientEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatientEvent::class);
    }

    // /**
    //  * @return PatientEvent[] Returns an array of PatientEvent objects
    //  */
    /*
    public function findAllPublishedOrderedByNewest($val)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :pat')
            ->setParameter('pat', $val)
            ->orderBy('p.id', 'ASC')
           // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }*/
    

    /*
    public function findOneBySomeField($value): ?PatientEvent
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
