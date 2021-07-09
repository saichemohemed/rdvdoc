<?php

namespace App\Repository;

use App\Entity\MedicalPersonalHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MedicalPersonalHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MedicalPersonalHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MedicalPersonalHistory[]    findAll()
 * @method MedicalPersonalHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicalPersonalHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MedicalPersonalHistory::class);
    }

    // /**
    //  * @return MedicalPersonalHistory[] Returns an array of MedicalPersonalHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MedicalPersonalHistory
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
