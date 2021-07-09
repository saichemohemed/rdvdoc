<?php

namespace App\Repository;

use App\Entity\PatternType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PatternType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatternType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatternType[]    findAll()
 * @method PatternType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatternTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatternType::class);
    }

    // /**
    //  * @return PatternType[] Returns an array of PatternType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PatternType
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
