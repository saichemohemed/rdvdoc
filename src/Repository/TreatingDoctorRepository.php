<?php

namespace App\Repository;

use App\Entity\TreatingDoctor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TreatingDoctor|null find($id, $lockMode = null, $lockVersion = null)
 * @method TreatingDoctor|null findOneBy(array $criteria, array $orderBy = null)
 * @method TreatingDoctor[]    findAll()
 * @method TreatingDoctor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TreatingDoctorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TreatingDoctor::class);
    }

    // /**
    //  * @return TreatingDoctor[] Returns an array of TreatingDoctor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TreatingDoctor
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
